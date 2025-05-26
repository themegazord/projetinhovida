<?php

namespace App\Imports;

use App\Models\Dados as ModelsDados;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class Dados implements ToModel
{
  public function model(array $row)
  {
    return new ModelsDados([
      'titulo' => $row[0],
      'fase_atual' => $row[1],
      'criado_em' => $row[2],
      'etiquetas' => $row[3],
      'ultimo_comentario' => $row[4],
      'numero_aproximado_de_unidades' => $row[5],
      'bairro' => $row[6],
      'cidade' => $row[7],
      'estado' => $row[8],
      'categoria_do_empreendimento' => $row[9],
      'ferramenta' => $row[10],
      'utm_source' => $row[11],
      'utm_medium' => $row[12],
      'utm_campaign' => $row[13],
      'utm_term' => $row[14],
      'utm_content' => $row[15],
      'versao_da_lp' => $row[16],
      'executivo_responsavel' => $row[17],
      'nome_executivo_expansao' => $row[18],
      'telefone_contato' => $row[19],
      'email_contato' => $row[20],
      'data_envio_proposta' => $row[21],
      'data_assinatura_contrato' => $row[22],
      'data_contrato_assinado_docusign' => $row[23],
      'sdr_responsavel' => $row[24],
      'numero_exato_unidades_total' => $row[25],
      'numero_unidades_ocupadas' => $row[26],
      'foi_roubado' => $row[27] === 'sim',
      'concorrente_nome' => $row[28],
      'teve_bonus_assembleia' => $row[29] !== null,
      'valor_bonus_assembleia' => $row[29],
    ]);
  }
}
