<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 6px;
      text-align: left;
    }
    th {
      background-color: #f0f0f0;
    }
    .comentario-vazio {
      background-color: #fff9c4; /* Amarelo claro */
    }
  </style>
</head>
<body>
  <h2>Relatório de Dados</h2>

  <table>
    <thead>
      <tr>
        @foreach ($headers as $header)
          <th>{{ $header['label'] }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach ($dados as $dado)
        <tr>
          @foreach ($headers as $header)
            @php
              $valor = $dado[$header['key']] ?? '';
              $classe = '';
              if ($header['key'] === 'ultimo_comentario' && empty($valor)) {
                $classe = 'comentario-vazio';
              }
            @endphp
            <td class="{{ $classe }}">
              @if ($header['key'] === 'criado_em')
                {{ \Carbon\Carbon::parse($valor)->format('d/m/Y H:i:s') }}
              @else
              {{ $valor }}
              @endif

            </td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
