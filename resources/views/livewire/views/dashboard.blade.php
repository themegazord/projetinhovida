@php
  $config1 = ['altFormat' => 'd/m/Y', 'mode' => 'range'];

  $fases = \DB::select('select distinct fase_atual from dados');
  $responsaveis = \DB::select('select distinct nome_executivo_expansao from dados');

  $cell_decoration = [
    'ultimo_comentario' => [
    'bg-yellow-500' => fn(\App\Models\Dados $dado) => $dado->ultimo_comentario === null
    ]
  ];
@endphp

<div class="p-4 md:p-6">
  <x-form wire:submit.prevent="armazena">
    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex-1">
        <x-file wire:model.live="arquivo" label="Importe a planilha" hint="Apenas arquivos XLS e XLSX" />
      </div>
      <div class="flex-1">
        <x-select wire:model="fase_atual" label="Fase Atual" :options="$fases" placeholder="Selecione a fase"
          option-label="fase_atual" option-value="fase_atual" />
      </div>
      <div class="flex-1">
        <x-choices-offline label="Executivo Responsável" wire:model="nome_executivo_expansao" :options="$responsaveis"
          option-label="nome_executivo_expansao" option-value="nome_executivo_expansao" placeholder="Consulte ..."
          single clearable searchable />
      </div>
      <div class="flex-1">
        <x-datepicker label="Criado em" wire:model="criado_em" icon="o-calendar" :config="$config1" />
      </div>
    </div>
    <x-slot:actions>
      <x-button wire:click="limpaFiltros" class="btn btn-secondary" label="Limpar Filtro" />
      <x-button wire:click="dados('mostrar')" wire.loading.attr="disabled" spinner="dados" class="btn btn-primary"
        label="Consultar" />
      <x-button type="submit" class="btn btn-success" label="Importar" wire:loading.attr="disabled"
        spinner="armazena" />
      <x-button class="btn btn-info" wire:click="exportaPDF" label="Exporta PDF" wire:loading.attr="disabled"
        spinner="exportaPDF" />
    </x-slot:actions>
  </x-form>

  <x-table :headers="$headers" :rows="$dados" per-page="porPagina" :per-page-values="[10, 20, 30]" with-pagination
    show-empty-text empty-text="Nenhum dado encontrado" :cell-decoration="$cell_decoration">
    @scope('cell_criado_em', $dado)
    {{ Carbon\Carbon::parse($dado->criado_em)->format('d/m/Y h:i:s') }}
    @endscope

    @scope('cell_ultimo_comentario', $dado)
    @if (empty($dado->ultimo_comentario))
      <span class="bg-error-700 w-full h-full"></span>
    @else
      {{ $dado->ultimo_comentario }}
    @endif
    @endscope

  </x-table>

</div>
