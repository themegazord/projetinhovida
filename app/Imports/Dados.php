<?php

namespace App\Imports;

use App\Models\Dados as ModelsDados;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;

class Dados implements ToModel
{
  public function model(array $row)
  {
    return new ModelsDados([
      'titulo' => $this->utf8($row[0]),
      'fase_atual' => $this->utf8($row[1]),
      'criado_em' => $this->utf8($this->parseDate($row[2])),
      'etiquetas' => $this->utf8($row[3]),
      'ultimo_comentario' => $this->utf8($row[4]),
      'numero_aproximado_de_unidades' => $this->utf8($row[5]),
      'bairro' => $this->utf8($row[6]),
      'cidade' => $this->utf8($row[7]),
      'estado' => $this->utf8($row[8]),
      'categoria_do_empreendimento' => $this->utf8($row[9]),
      'ferramenta' => $this->utf8($row[10]),
      'utm_source' => $this->utf8($row[11]),
      'utm_medium' => $this->utf8($row[12]),
      'utm_campaign' => $this->utf8($row[13]),
      'utm_term' => $this->utf8($row[14]),
      'utm_content' => $this->utf8($row[15]),
      'versao_da_lp' => $this->utf8($row[16]),
      'executivo_responsavel' => $this->utf8($row[17]),
      'nome_executivo_expansao' => $this->utf8($row[18]),
      'telefone_contato' => $this->utf8($row[19]),
      'email_contato' => $this->utf8($row[20]),
      'data_envio_proposta' => $this->utf8($row[21]),
      'data_assinatura_contrato' => $this->utf8($row[22]),
      'data_contrato_assinado_docusign' => $this->utf8($row[23]),
      'sdr_responsavel' => $this->utf8($row[24]),
      'numero_exato_unidades_total' => $this->utf8($row[25]),
      'numero_unidades_ocupadas' => $this->utf8($row[26]),
      'foi_roubado' => $this->utf8($row[27] === 'sim'),
      'concorrente_nome' => $this->utf8($row[28]),
      'teve_bonus_assembleia' => $this->utf8($row[29] !== null),
      'valor_bonus_assembleia' => $this->utf8($row[29]),
    ]);
  }

  private function utf8($value)
  {
    return is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'auto') : $value;
  }
  protected function parseDate($value)
  {
    try {
      if (is_numeric($value)) {
        // Caso seja um número de série do Excel
        return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
      }

      return Carbon::parse($value);
    } catch (\Exception $e) {
      return null; // ou alguma data padrão, ou log de erro
    }
  }
}
