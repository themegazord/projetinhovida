<div class="p-4 md:p-6">
  <x-form wire:submit.prevent="armazena">
    <x-file wire:model.live="arquivo" label="Importe a planilha" hint="Apenas arquivos XLS e XLSX" />
    <x-slot:actions>
      <x-button type="submit" class="btn btn-success" label="Importar" />
    </x-slot:actions>
  </x-form>

  @php
    $dados = \App\Models\Dados::paginate($porPagina ?? 10);

    $headers = [
      ['key' => 'titulo', 'label' => 'Título'],
      ['key' => 'fase_atual', 'label' => 'Fase Atual'],
      ['key' => 'criado_em', 'label' => 'Criado em'],
      ['key' => 'ultimo_comentario', 'label' => 'Último Comentário'],
      ['key' => 'executivo_responsavel', 'label' => 'Executivo Responsável'],
      ['key' => 'nome_executivo_expansao', 'label' => 'Executivo Expansão'],
    ];
  @endphp

  <x-table :headers="$headers" :rows="$dados" with-pagination show-empty-text empty-text="Nenhum dado encontrado"/>
</div>
