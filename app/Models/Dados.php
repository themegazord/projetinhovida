<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dados extends Model
{
  protected $fillable = [
    'titulo',
    'fase_atual',
    'criado_em',
    'etiquetas',
    'ultimo_comentario',
    'numero_aproximado_de_unidades',
    'bairro',
    'cidade',
    'estado',
    'categoria_do_empreendimento',
    'ferramenta',
    'utm_source',
    'utm_medium',
    'utm_campaign',
    'utm_term',
    'utm_content',
    'versao_da_lp',
    'executivo_responsavel',
    'nome_executivo_expansao',
    'telefone_contato',
    'email_contato',
    'data_envio_proposta',
    'data_assinatura_contrato',
    'data_contrato_assinado_docusign',
    'sdr_responsavel',
    'numero_exato_unidades_total',
    'numero_unidades_ocupadas',
    'foi_roubado',
    'concorrente_nome',
    'teve_bonus_assembleia',
    'valor_bonus_assembleia',
  ];

  protected $casts = [
    'criado_em' => 'datetime',
    'data_envio_proposta' => 'datetime',
    'data_assinatura_contrato' => 'datetime',
    'data_contrato_assinado_docusign' => 'datetime',
    'foi_roubado' => 'boolean',
    'teve_bonus_assembleia' => 'boolean',
  ];
}
