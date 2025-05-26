<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('dados', function (Blueprint $table) {
      $table->id();
      $table->string('titulo')->nullable();
      $table->string('fase_atual')->nullable();
      $table->timestamp('criado_em')->nullable();
      $table->string('etiquetas')->nullable();
      $table->text('ultimo_comentario')->nullable();
      $table->string('numero_aproximado_de_unidades')->nullable();
      $table->string('bairro')->nullable();
      $table->string('cidade')->nullable();
      $table->string('estado')->nullable();
      $table->string('categoria_do_empreendimento')->nullable();
      $table->string('ferramenta')->nullable();
      $table->string('utm_source')->nullable();
      $table->string('utm_medium')->nullable();
      $table->string('utm_campaign')->nullable();
      $table->string('utm_term')->nullable();
      $table->string('utm_content')->nullable();
      $table->string('versao_da_lp')->nullable();
      $table->string('executivo_responsavel')->nullable();
      $table->string('nome_executivo_expansao')->nullable();
      $table->string('telefone_contato')->nullable();
      $table->string('email_contato')->nullable();
      $table->timestamp('data_envio_proposta')->nullable();
      $table->timestamp('data_assinatura_contrato')->nullable();
      $table->timestamp('data_contrato_assinado_docusign')->nullable();
      $table->string('sdr_responsavel')->nullable();
      $table->string('numero_exato_unidades_total')->nullable();
      $table->string('numero_unidades_ocupadas')->nullable();
      $table->boolean('foi_roubado')->default(false);
      $table->string('concorrente_nome')->nullable();
      $table->boolean('teve_bonus_assembleia')->default(false);
      $table->decimal('valor_bonus_assembleia', 10, 2)->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('dados');
  }
};
