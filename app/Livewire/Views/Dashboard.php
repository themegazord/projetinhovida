<?php

namespace App\Livewire\Views;

use App\Imports\Dados;
use App\Models\Dados as ModelsDados;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class Dashboard extends Component
{
  use WithFileUploads, Toast, WithPagination;
  public $arquivo;
  public ?string $nome_executivo_expansao = null;
  public ?string $fase_atual = null;
  public ?string $criado_em = null;

  public array $headers = [
    ['key' => 'titulo', 'label' => 'Título'],
    ['key' => 'fase_atual', 'label' => 'Fase Atual'],
    ['key' => 'criado_em', 'label' => 'Criado em'],
    ['key' => 'ultimo_comentario', 'label' => 'Último Comentário'],
    ['key' => 'executivo_responsavel', 'label' => 'Executivo Responsável'],
    ['key' => 'nome_executivo_expansao', 'label' => 'Executivo Expansão'],
  ];
  public int $porPagina = 10;

  #[Title('Dashboard')]
  public function render()
  {
    return view('livewire.views.dashboard', [
      'dados' => $this->dados('mostrar'),
      'headers' => $this->headers,
    ]);
  }

  public function limpaFiltros()
  {
    $this->fase_atual = null;
    $this->nome_executivo_expansao = null;
    $this->criado_em = null;
    $this->resetPage();
  }

  public function dados(string $modo): LengthAwarePaginator|Collection
  {
    $dados = \App\Models\Dados::query()->select(
      'titulo',
      'fase_atual',
      'criado_em',
      'ultimo_comentario',
      'executivo_responsavel',
      'nome_executivo_expansao'
    );

    if ($this->fase_atual) {
      $dados->where('fase_atual', $this->fase_atual);
    }

    if ($this->nome_executivo_expansao) {
      $dados->where('nome_executivo_expansao', $this->nome_executivo_expansao);
    }

    if ($this->criado_em) {
      $datas = str_contains($this->criado_em, ' até ')
        ? explode(' até ', $this->criado_em)
        : $this->criado_em;

      if (is_array($datas)) {
        $dados->whereBetween('criado_em', array_map(fn($d) => Carbon::parse($d)->startOfDay(), $datas));
      } else {
        $dados->whereDate('criado_em', Carbon::parse($datas)->toDateString());
      }
    }

    return match ($modo) {
      'exportar' => $dados->get(),
      'mostrar' => $dados->paginate($this->porPagina),
    };

  }


  public function armazena()
  {
    $this->validate([
      'arquivo' => 'required|file', // 1MB Max
    ], messages: [
      'arquivo.required' => 'O arquivo é obrigatório.',
      'arquivo.file' => 'O arquivo deve ser um arquivo válido.',
    ]);

    $nomeArquivo = $this->arquivo->store('uploads');

    \App\Models\Dados::query()->delete();

    ini_set('memory_limit', '-1');
    Excel::import(new Dados, storage_path('app/private/' . $nomeArquivo));
    ini_set('memory_limit', '512M');

    unlink(storage_path('app/private/' . $nomeArquivo)); // Remove o arquivo após a importação

    $this->success('Arquivo importado com sucesso!');
  }

  public function exportaPDF(): mixed
  {
    $pdf = Pdf::loadView('livewire.views.pdf.lista', [
      'headers' => $this->headers,
      'dados' => $this->dados('exportar'),
    ]);

    return response()->streamDownload(function () use ($pdf) {
      echo $pdf->stream();
    }, 'relatorio.pdf');
  }
}
