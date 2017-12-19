<?php

//carrega arquivo com o layout
require_once('classes/display_main.php');
require_once('funcoes/session_functions.php');



if (session_id() == '') {
    session_start();
}


check_loggedin();


$display_main = new display_main; //associa uma variával à classe de carregamento do layout
//atualiza variáveis de sessão se usuário estiver logado




$display_main->head('@import url(\'css/artigo.css\');');

$display_main->topo(false);


$display_main->painel_esquerda();

$display_main->conteudo('
<h1>Como fazer uma entrevista de emprego</h1>
<img src="gfx/artigos/entrevista.png" class="artigo_imagem" alt="entrevista de emprego"/>
<p>Nesse artigo iremos discutir sobre as principais dicas para entrevista, de modo que você possa aumentar suas chances e sair na frente da concorrência.</p>


<p>A entrevista de emprego é uma das etapas pelas quais todo candidato deverá passar e nunca será um momento fácil de se enfrentar. Você estará encontrando novas pessoas, vendendo ‘o seu peixe’ e suas habilidades, e frequentemente sendo avaliado no que sabe e também no que não sabe.</p>

<p>Abaixo estão algumas dicas importantíssimas que podem ajudá-lo a se preparar para entrevista, de forma que boa parte do stress envolvendo o momento seja dissipado e você fique confontável durante o processo.</p>


<h3>Dicas</h3>

<h4>Pratique</h4>

<p>Pesquise quais são as principais perguntas  e treine sua resposta dias antes da entrevista. Pense sobre exemplos  que possa utilizar para justificar suas afirmativas  e para descrever suas habilidades. Mostrar evidências de seu sucesso é uma excelente forma de se auto-promover. Uma boa técnica que também pode ser utilizada é “entrevistar o recrutador”.</p>

<h4>Pesquise</h4>

<p>Possivelmente você será questionado sobre o que sabe a respeito da empresa que está lhe entrevistando e uma boa forma de responder seria pesquisando previamente sobre a instituição. Anote todos os dados: Percentual de crescimento, cultura empresarial, quando foi fundada, quais foram as últimas conquistas e prêmios, etc. Use todas essas informações a seu favor durante a entrevista, demonstrando que você é um candidato que realmente se importa com o cargo em questão.</p>

<h4>Prepare-se</h4>

<p>Vista-se de modo apropriado com a empresa em que irá fazer a entrevista. A dica é seguir o padrão de vestimenta de todos os colaboradores.</p>

<h4>Chegue com antecedência</h4>

<p>Um atraso para a entrevista pode acabar com todas as suas chances imediatamente. Chegue 5 a 10 minutos mais cedo e, se possível, vá alguns dias antes até o local para se saber como chegar lá facilmente.</p>

<h4>Fique calmo(a)!</h4>
<p>
Durante a entrevista de emprego relaxe e fique o mais calmo possível. Mantenha contato visual com o entrevistador e ouça a pergunta por completo antes de responder. Ah, e preste muita atenção! A pior coisa é alguém te perguntar algo e você estar em “outro mundo”.
</p>

<h4>Mostre o que você sabe</h4>
<p>
Quando descrever todos as suas conquistas de carreira faça o máximo possível para relacionar o que você sabe com o que a empresa precisa.
</p>

<h4>Após a entrevista</h4>
<p>
Uma dica é enviar um e-mail ou carta de agradecimento pela oportunidade (nas próximas 24 horas após a entrevista) , reforçando o interesse pelo cargo. Se você participar de vários processos seletivos, envie para cada empresa uma mensagem pessoal de agradecimento.
</p>

<h4>Quer ter mais chances?</h4>
<p>
Pensando no melhor para nossos candidatos criamos um pacote de benefícios exclusivos para garantir que você saia na frente da concorrência! Com ele você poderá candidatar-se em quantas vagas quiser, ter acesso a video-aulas especialmente desenvolvidas para que você possa ter mais chances de entrar para o mercado de trabalho. 

<a href="membro_vip.php" target="_self"><strong>Clique aqui faça parte agora mesmo desse grupo seleto (Membro VIP).</strong></a></p>



');


$display_main->painel_direita();
$display_main->fundo();
?>


