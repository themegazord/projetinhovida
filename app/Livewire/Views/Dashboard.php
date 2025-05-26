<?php

namespace App\Livewire\Views;

use App\Imports\Dados;
use App\Models\Dados as ModelsDados;
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
  #[Title('Dashboard')]
  public function render()
  {
    return view('livewire.views.dashboard');
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
}
