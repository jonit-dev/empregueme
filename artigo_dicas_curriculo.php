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

?>
<h1>Dicas de um bom currículo</h1>
<img src="gfx/artigos/curriculo.png" class="artigo_imagem" alt="curriculo"/>
<p>Atenção candidato! Fique atendo para as dicas a seguir, que irão lhe ajudar na criação de um bom currículo. Foque em cada um dos itens a seguir, pois isso pode fazer a diferença entre conseguir a tão almejada vaga ou ficar mais um mês desempregado.</p>

<a href="main.php?banner=curriculo" target="_self">
<p class="vermelho_destaque"><strong>Caso você ainda não tenha criado o seu currículo, clique aqui para criá-lo</strong></p>
</a>

<h4>Não deixe passar nenhum erro de ortografia</h4>

<p><strong>Escorregões ortográficos (por mínimos que sejam) vão saltar aos olhos dos recrutadores.</strong> Afinal este tipo de erro é inadmissível e cometê-lo é o primeiro passo para arruinar as suas chances de ter uma entrevista de emprego. Antes de enviar o currículo, peça sempre para uma ou duas pessoas lerem o seu currículo para se certificar de que nenhum deslize – não corrigido pelo corretor ortográfico- passe batido.</p>

<h4>Aposte na clareza e na objetividade</h4>

<p>A apresentação do currículo pode ser inovadora na forma, contanto que as informações continuem visíveis e que a clareza não seja prejudicada. Procure sempre deixar o seu currículo de fácil leitura.</p>

<h4>Objetivo profissional deve ser alinhado à oportunidade em questão</h4>

<p>Vai se cadastrar a diferentes oportunidades? Para cada uma delas crie um objetivo profissional alinhado. A falta de relação direta com o tipo de trabalho oferecido indica ausência de foco e dá a entender que você está disparando currículos aleatoriamente.</p>

<h4>Coloque links</h4>

<p>Dar um toque multimídia ao currículo apostando em links  - para portfólio virtual, perfil no LinkedIn, blog profissional ou até um vídeo de apresentação no Youtube -  pode ser um diferencial interessante no material que você apresenta ao mercado.</p>

<h4>Não adicione imagens</h4>
<p>
Fotos e imagens tornam o arquivo pesado e são totalmente desnecessárias, de acordo com João Marco, diretor da Michael Page. Não se esqueça de que o objetivo do currículo é apresentar a sua trajetória profissional, não ilustrá-la com fotos.</p>


<img src="gfx/artigos/pretensao.jpg" alt="pretensão salarial" class="artigo_imagem" width="237" height="206"/>
<h4>Só coloque pretensão salarial se ela for solicitada</h4>

<p>
De acordo com o diretor da Michael Page, colocar pretensão salarial no currículo pode ser um tiro no pé. Isso porque você pode ser eliminado da seleção para um projeto apenas por ter indicado um salário mais robusto. A regra então é colocar essa informação apenas quando ela é solicitada, o que que acontece em alguns sites de recrutamento.
</p>

<h4>Mostre que tem potencial</h4>
<p>
Experimentos recentes de pesquisadores das universidades de Stanford e Harvard indicam que ter potencial é até mais importante do que as conquistas alcançadas na carreira.
Assim, além de transmitir no currículo os bons resultados atingidos ao longo da carreira, destaque também a sua formação acadêmica, que é um dos pontos fortes para demonstrar que você tem potencial. Principalmente, se ela estiver alinhada ao cargo em questão. Cursos, treinamentos relevantes para aquela oportunidade profissional não devem ficar de fora.
</p>

<h3 class="vermelho_destaque">Dúvidas Frequentes</h3>

<h4>Devo ser generalista na hora de redigir o objetivo?</h4>
<p>
Depende. Em alguns setores é mais fácil delimitar seus objetivos profissionais. Em outros, não. A dica, segundo Sérgio Sabino, da Michael Page, é sempre se candidatar para oportunidades profissionais coerentes com seu plano de carreira. “Quanto mais preciso for isso, melhor para o recrutador”. Mas cuidado para não cair em contradição.
Regra de ouro? Estude o anúncio de emprego com afinco antes de redigir seu currículo. Se o currículo for generalista (daqueles que você cadastra em sites, por exemplo), seja coerente com seu propósito de carreira.</p>

<h4>Posso usar o mesmo currículo para diferentes oportunidades?</h4>
<p>
Não. Em uma era que personalização é tudo, a regra é ter um currículo para cada oportunidade. Em outros termos, cada panela tem que ter sua tampa, neste sentido. O ideal, de acordo com especialistas, é ter um currículo base, mas adaptá-lo ou, em termos mais modernos, customizá-lo para cada ocasião – tendo em vista o espírito da empresa e cargo em questão.</p>

<h4>Como adaptar meu currículo para cada ocasião?</h4>
<p>
Os pontos mais relevantes da trajetória profissional, salvo algumas exceções, não mudam. O que pode ser mudado são as conquistas que você alcançou em cada passagem profissional. Assim, ajuste para cada versão, os projetos, as conquistas que mais tem relação com o cargo que você pleiteia.</p>


<h4>Que tipo de conquista vale para o currículo?</h4>
<p>
Dados numéricos sempre caem bem no currículo. Por isso, quando mais objetiva for a conquista, melhor. “Realizações que reflitam aumento de receita, redução de custos, que ajudem no desempenho da companhia são exemplos”, diz Sabino. “Você tem que mostrar o seu valor”. E a descrição do que você fez em cada cargo não é suficiente para isso. Por isso, invista em dados objetivos que comprovem isso.</p>


<h4>Como mostrar meu nível de conhecimento em um idioma estrangeiro?</h4>
<p>
Mentir no currículo é o pior erro que um candidato pode cometer. E isso vale até para as formas mais sutis da mentira: como “dourar” o seu nível de conhecimento em um idioma estrangeiro. Dez minutos de conversa em inglês, durante a entrevista, por exemplo, são suficientes para o recrutador checar se você é fluente ou não. A dica? “Faça uma autocrítica e na dúvida, procure um especialista credenciado para avaliar seu nível de inglês”.</p>

<h4>Preciso listar meus hobbies?</h4>
<p>
Não é obrigatório, mas pode ajudar o recrutador a traçar seu perfil profissional. Afinal, a sua rotina fora do trabalho pode falar muito sobre você. “Os hobbies têm a função de mostrar as suas próprias competências”, diz Sabino. “É mais um complemento para traçar seu perfil”.</p>

<h4>Que tipo de trabalho voluntário "cabe" no currículo?</h4>
<p>
Ação de caridade, como doar dinheiro para alguma instituição, não vale. “Se o trabalho é periódico, se você tem comprometimento pode mostrar engajamento e preocupação com a sociedade”, diz Sabino. Mas, segundo ele, tal experiência tende a não ser decisiva.</p>

<h4>Posso listar minhas principais competências?</h4>
<p>
“O recrutador é um incrédulo por natureza. Listar suas competências pode ser mais um problema do que uma solução”, diz Sabino. Afinal, quem garante que o recrutador irá concordar com você. Por isso, a dica é, em vez de listar adjetivos que descrevam quem você é, atenha-se aos fatos: escolha dados, experiências e resultados que apontem para tais qualidades. “Deixe este critério de avaliação para o recrutador”, diz Sabino.</p>

<h4>Ainda não me formei. Como explicar isso no currículo?</h4>
<p>
Neste caso, a solução é detalhar a previsão de conclusão do curso em questão em vez de escrever a palavra “cursando”.</p>


<h4>Parei alguns cursos no meio do caminho, devo listá-los?</h4>
<p>
Não. “Se interrompeu o curso, o ideal é não colocá-lo no currículo”, afirma Elvira Berni, diretora da People on Time. Só vale mencioná-lo se planejar retomar os estudos no curto prazo.</p>


<h4>Posso omitir algumas experiências?</h4>
<p>
De acordo com Elvira Berni, da People on Time, passagens muito curtas, de apenas alguns dias, nem sempre precisam ser listadas. “Foque nos cargos que agreguem valor para a sua carreira”, diz.
A mesma regra vale para as experiências profissionais de início de carreira que não foram tão relevante.s “O foco tem que estar nos últimos cinco ou dez anos”, afirma a especialista.
Para não passar a impressão de má-fé (caso o recrutador julgue que a omissão teve segundas intenções), apenas cite as experiências – sem entrar em detalhes -, como sugeriu Renato Grinberg, autor do livro “O instinto do sucesso” em um dos vídeos de carreira.
</p>

<h4>Como escolher as palavras-chave certas?</h4>
<p>
O método mais eficaz para garantir que o recrutador irá encontrar seu currículo nos sistemas de buscas especializados é investir em palavras-chave. “Selecione os termos mais comuns da sua área de atuação e os que melhor explicam o que você faz, realmente”, diz Elvira. Dica: leia com atenção os anúncios das oportunidades profissionais e repita as principais palavras em seu currículo.
</p>

<h4>Devo colocar pretensão salarial?</h4>
<p>
Nesta etapa, entre no assunto “salário” apenas quando for indagado sobre isto. Se o anúncio pede “pretensão salarial”, obedeça-o e liste a remuneração que recebia/recebe no último emprego - a variável deve ser incluída. 
</p>

<h4>Qual a regra para dados pessoais?</h4>
<p>
Há alguns anos, currículo bom era aquele que listava, em minúcias, todos os dados pessoais possíveis. Estado civil, quantidade de filhos, RG e CPF. Tudo. Tudo ia parar no documento. 
Para os desavisados: esta regra, definitivamente, acabou. No máximo, cite qual seu estado civil e o endereço - sem mencionar número, por exemplo. O foco no currículo são suas qualificações.
</p>

<h4>Preciso colocar foto?</h4>
<p>
Já se foi o tempo em que uma foto do candidato era um item tão relevante quanto a formação acadêmica. Mas, em alguns setores e empresas, a imagem do aspirante à oportunidade profissional segue como exigência. Quando a empresa pede por uma foto, nada de escolher uma imagem de viagem. Quanto mais sisudo, melhor.
</p>




<?php


$display_main->painel_direita();
$display_main->fundo();
?>


