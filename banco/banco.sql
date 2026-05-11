.open banco/blog_racing.db
.mode table
.output banco/verificacao.txt;

DROP TABLE IF EXISTS noticias;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS perfis;
DROP TABLE IF EXISTS categorias;

CREATE TABLE categorias (
	id_categoria INTEGER PRIMARY KEY AUTOINCREMENT,
	nome_categoria TEXT,
	sigla_categoria TEXT
);

INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('Formula 1','f1');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('Formula 2','f2');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('Formula 3','f3');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('Formula 4','f4');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('F1 Academy','f1academy');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('Formula E','fe');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('IndyCar','indy');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('World Endurance Championship','wec');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('World Rally Championship','wrc');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('Nascar','nascar');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('MotoGP','moto');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('Moto2','moto2');
INSERT INTO categorias (nome_categoria, sigla_categoria) VALUES ('Moto3','moto3');

CREATE TABLE perfis (
	id_perfil INTEGER PRIMARY KEY AUTOINCREMENT,
	nome_perfil TEXT
);

INSERT INTO perfis (nome_perfil) VALUES ('Admin');
INSERT INTO perfis (nome_perfil) VALUES ('Usuario');

CREATE TABLE usuarios (
	id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
	nome TEXT,
	user TEXT UNIQUE,
	email TEXT UNIQUE,
	telefone TEXT,
	senha TEXT,
	perfil_id INTEGER NOT NULL,
	FOREIGN KEY (perfil_id) REFERENCES perfis(id_perfil)
	ON DELETE RESTRICT
);

INSERT INTO usuarios (nome, user, email, telefone, senha, perfil_id) VALUES
('Sir Lewis Hamilton', 'lewis_hamilton', 'lewishamilton44@gmail.com', '(51) 3227-7663', '$2y$10$Zl4.oULynbeEICakvhu1s.YV7fMXLJiKS2LcJL1fGoZRsAOTZTWGW', 2);

INSERT INTO usuarios (nome, user, email, telefone, senha, perfil_id) VALUES
('Felipe Remus', 'felipe_remus', 'felipeteste@gmail.com', '(21) 97654-3210', '$2y$10$BGrXsXHx2zSuDAqGeTpekeyl5kaQCAV1WaUbMPZ/03iCwqyBAZU7S', 1);

CREATE TABLE noticias (
	id_noticia INTEGER PRIMARY KEY AUTOINCREMENT,
	titulo_noticia TEXT,
	texto_noticia TEXT,
	imagem_noticia TEXT,
	data_noticia DATE,
	categoria_id INTEGER NOT NULL,
	usuario_id INTEGER NOT NULL,
	FOREIGN KEY (categoria_id) REFERENCES categorias(id_categoria)
	ON DELETE RESTRICT,
	FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario)
	ON DELETE CASCADE
);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Max Verstappen acabou.', 
	'Verstappen tá um bagre nesse regulamento. kkkkkkkkkkkkk', 
	'img-noticia/1-max-sid.jpg', 
	'2026-03-16', 1, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Rumores: BYD estuda entrada na F1 como fornecedora de motores?', 
	'Especulações no paddock indicam que a gigante chinesa BYD estaria avaliando uma possível incursão na Fórmula 1. Com o novo regulamento de motores sustentáveis previsto para 2026, a marca líder em veículos elétricos vê uma oportunidade de alinhar sua tecnologia de baterias ao esporte. Embora não haja confirmação oficial, fontes próximas à diretoria sugerem que um estudo de viabilidade está em andamento para decidir se a empresa entrará como construtora completa ou apenas como fornecedora de power units.', 
	'img-noticia/2-byd-f1.jpg', 
	'2026-03-18', 1, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(
    'Sébastien Ogier é confirmado como piloto principal do WRC em 2026',
    'Sébastien Ogier, oito vezes campeão mundial, foi oficialmente confirmado como piloto principal para a temporada de 2026. O francês continuará sua parceria com a equipe M-Sport Ford, buscando conquistar seu nono título mundial e consolidar sua posição como o piloto mais vitoriante da história do WRC. Com a mudança de regulamento técnico prevista para este ano, Ogier expressa entusiasmo em trabalhar com os novos protótipos Rally1, que prometem maior eficiência de combustível e desempenho aprimorado. Seu copiloto Julien Ingrassia permanecerá ao seu lado, mantendo uma das parcerias mais bem-sucedidas do motorsport contemporâneo. A dupla francêsa terá como adversários principais Elfyn Evans, também da M-Sport, e pilotos de outras fabricantes como Hyundai e Toyota. Ogier já venceu 57 eventos mundiais em sua carreira e continua demonstrando competitividade de alto nível. A temporada de 2026 promete ser emocionante, com diversas mudanças técnicas e novas frentes de competição entre as fabricantes. Especialistas apontam que a experiência de Ogier será crucial para o desenvolvimento do novo carro M-Sport Rally1, que sofreu significativas atualizações para se adequar às novas especificações do campeonato.',
    'img-noticia/3-rally.jpg',
    '2026-03-17', 9, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Ferrari apresenta novo pacote aerodinâmico para o GP da Espanha', 
	'A Scuderia trouxe atualizações significativas para o assoalho e os pontões do SF-26, visando corrigir instabilidades em curvas de alta velocidade. Os pilotos testaram as peças durante os treinos livres em Barcelona, reportando um equilíbrio mais previsível. A equipe espera brigar pelo pódio em um circuito que tradicionalmente favorece a eficiência aerodinâmica.', 
	'img-noticia/4-ferrari-sf26.jpg', 
	'2026-03-20', 1, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Rookie brasileiro surpreende e vence corrida principal em Mônaco', 
	'Em uma atuação de destaque, o estreante na F2 demonstrou maturidade sob pressão para liderar as últimas voltas na pista de rua. A estratégia de pneus intermediários e uma ultrapassagem limpa na Rascasse foram decisivas para a vitória. A equipe elogiou o crescimento do piloto e destacou que a conquista reforça o pipeline de talentos para a próxima temporada.', 
	'img-noticia/5-f2-monaco.png', 
	'2026-03-22', 2, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'FIA anuncia mudanças no sistema de qualificação para 2027', 
	'O órgão regulador revelou um novo formato que combinará tempos cronometrados com desempenho em corrida curta, buscando reduzir a poluição nas sessões de treino e aumentar a competitividade. As equipes terão mais flexibilidade na configuração dos carros, mas as restrições orçamentárias permanecem rigorosas. A transição será monitorada ao longo da temporada atual.', 
	'img-noticia/6-f3-format.png', 
	'2026-03-25', 3, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Campeonato Brasileiro de F4 ganha nova etapa em Interlagos', 
	'A expansão do calendário inclui uma rodada adicional no autódromo de São Paulo, com foco em reduzir custos logísticos e aumentar a exposição dos jovens pilotos. A organização promete transmissões em alta resolução e maior interação com as equipes de desenvolvimento. O evento servirá como vitrine para olheiros de categorias europeias.', 
	'img-noticia/7-f4-brasil.png', 
	'2026-03-28', 4, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Nova parceria visa expandir base de talentos femininos no grid', 
	'A F1 Academy anunciou um acordo com academias de karting em três continentes para identificar e patrocinar pilotos com idades entre 14 e 18 anos. O programa incluirá mentorias técnicas, suporte psicológico e bolsas de estudo. O objetivo é criar um pipeline sustentável que alimente as categorias de acesso com diversidade e competência técnica.', 
	'img-noticia/8-f1academy-talent.png', 
	'2026-04-01', 5, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Jaguar TCS Racing domina etapa de Berlim com estratégia de energia',
	'A equipe britânica mostrou supremacia no gerenciamento de recuperação de energia, permitindo que seu piloto líder conservasse bateria para um ataque decisivo nas voltas finais. A nova geração de powertrains permitiu maior eficiência em frenagens, e a Jaguar soube explorar essa vantagem em um circuito exigente. A vitória reforça a competitividade da marca na temporada.', 
	'img-noticia/9-berlin-e.png', 
	'2026-04-05', 6, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Preparativos para as 500 Milhas de Indianápolis entram em fase crítica', 
	'As equipes ajustam aerofólios e suspensões para o oval mais tradicional do mundo, onde a velocidade média ultrapassa 370 km/h. Novos compostos de pneus foram homologados para melhorar a aderência em curvas de alta inclinação. Pilotos veteranos e rookies disputam posições nos treinos de classificação, com o foco na confiabilidade dos motores híbridos recém-introduzidos.', 
	'img-noticia/10-indy500.jpg', 
	'2026-04-10', 7, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Toyota e Porsche duelam em Le Mans nas primeiras 24 horas simuladas', 	
	'Durante o teste coletivo, as fabricantes trocaram a liderança múltiplas vezes, destacando a importância da gestão de tráfego e da eficiência dos híbridos. A Toyota focou na durabilidade do sistema de recuperação, enquanto a Porsche ajustou a distribuição de peso para melhorar a estabilidade em retas. O campeonato promete equilíbrio inédito entre as classes Hypercar.', 
	'img-noticia/11-lemans-test.png', 
	'2026-04-15', 8, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Toyota Gazoo Racing revela nova versão do Yaris Rally1 para terra', 
	'A equipe japonesa apresentou atualizações focadas na absorção de impacto e na tração em superfícies soltas. O novo diferencial central e ajustes na suspensão traseira prometem melhorar a resposta em trechos lamacentos. O chefe de equipe destacou que o desenvolvimento foi guiado por dados coletados nas etapas europeias da temporada passada.', 
	'img-noticia/12-wrc-yaris.jpg', 
	'2026-04-20', 9, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Introdução de carro elétrico híbrido ganha força nas pistas ovais',
	'A série está testando um protótipo que combina motor V8 tradicional com unidade elétrica para ultrapassagens e frenagens. O objetivo é manter a essência do stock car enquanto reduz emissões e amplia o leque de estratégias de corrida. As equipes demonstraram interesse, mas destacam a necessidade de ajustes na regulamentação de peso e balanceamento.', 
	'img-noticia/13-nascar-hybrid.png', 
	'2026-04-25', 10, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Ducati mantém hegemonia, mas Yamaha mostra evolução com novo motor', 
	'A fabricante italiana continua dominante nas retas, porém a japonesa surpreendeu com ganhos de torque em saídas de curva, reduzindo a diferença para menos de 0.3s por volta. A nova carenagem melhorou a proteção aerodinâmica, permitindo que o piloto se mantenha mais estável em frenagens tardias. A temporada promete disputas mais equilibradas.', 
	'img-noticia/14-motogp-tech.png', 
	'2026-05-01', 11, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Regra de motor único garante equilíbrio técnico entre equipes',
	'A padronização do propulsor permitiu que a diferença de desempenho fosse ditada apenas pelo chassis, suspensão e talento do piloto. Jovens pilotos têm aproveitado essa uniformidade para mostrar consistência e ritmo de prova. A organização planeja manter o formato por mais duas temporadas, avaliando o impacto no desenvolvimento de carreiras.', 
	'img-noticia/15-moto2-chassis.png', 
	'2026-05-05', 12, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Estratégias de rascunho dominam batalhas finais nas etapas de rua', 
	'Com a limitação de potência, os pilotos dependem do vácuo e de manobras tardias para superar adversários. A nova regra de limite de inclinação em curvas de baixa velocidade busca reduzir quedas e priorizar a técnica sobre a agressividade. Equipes menores têm se beneficiado da estabilidade regulatória para competir de igual para igual com as tradicionais.', 
	'img-noticia/16-moto3-draft.png', 
	'2026-05-08', 13, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Red Bull Racing testa novo conceito de sidepod em Silverstone', 
	'A equipe austríaca trouxe uma solução radical para os radiadores laterais, buscando melhorar o fluxo de ar para o difusor traseiro. Os primeiros dados de túnel de vento indicam ganhos significativos de downforce sem aumento de arrasto. A validação na pista será crucial para definir a direção de desenvolvimento do carro para a segunda metade da temporada.', 
	'img-noticia/17-rb-silverstone.jpg', '2026-05-10', 1, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Disputa pelo título da F2 se acirra após rodada dupla em Mônaco', 
	'Com a diferença de pontos reduzida para apenas 12, a briga pela liderança do campeonato entrou em nova fase. A consistência nas largadas e a gestão de pneus degradados têm sido os fatores decisivos. Analistas apontam que a pressão psicológica pode ser tão determinante quanto o desempenho técnico nas próximas etapas.', 
	'img-noticia/18-f2-title-fight.png', '2026-05-12', 2, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Piloto argentino conquista pole position surpreendente em Spa-Francorchamps', 
	'Em condições de pista molhada, o jovem talento da F3 demonstrou controle excepcional, cravando o melhor tempo na Q3. A equipe, que lutava por pontos no início do ano, vê essa conquista como um ponto de virada. A chuva intensa durante a classificação embaralhou as expectativas e favoreceu pilotos com maior sensibilidade ao limite de aderência.', 
	'img-noticia/19-f3-spa-pole.png', '2026-05-14', 3, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Nova regulamentação de segurança para F4 entra em vigor imediatamente', 
	'Após revisão dos protocolos de impacto lateral, a FIA exigiu reforços estruturais nos cockpits de todos os chassis homologados. As equipes tiveram 48 horas para adaptar os carros antes da próxima etapa. A medida visa proteger os pilotos em incidentes de alta energia, alinhando a categoria aos padrões das fórmulas superiores.', 
	'img-noticia/20-f4-safety.png', '2026-05-16', 4, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Nissan Formula E Team revela atualização de software para recuperação de energia', 
	'A fabricante japonesa focou em algoritmos de predição de frenagem, permitindo que os pilotos recuperem mais energia em descidas e curvas lentas. O update foi testado em simulador e mostrou potencial para ganhar até 5% de eficiência por volta. A equipe espera subir no campeonato de construtores com essa vantagem técnica.', 
	'img-noticia/21-nissan-fe-software.png', '2026-05-20', 6, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'IndyCar confirma calendário expandido para 2027 com etapa no Brasil',
	'A série americana oficializou uma corrida em circuito urbano no Rio de Janeiro, marcando seu retorno ao país após mais de uma década. O traçado provisório contorna pontos turísticos da cidade e deve exigir alto nível de precisão dos pilotos. A organização vê o mercado brasileiro como estratégico para a expansão internacional da categoria.', 
	'img-noticia/22-indy-rio.png', '2026-05-22', 7, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Ferrari AF Corse vence as 6 Horas de Spa com estratégia agressiva',
	'A equipe italiana optou por parar menos vezes que os rivais, confiando na durabilidade dos pneus e na eficiência do híbrido. A decisão arriscada pagou dividends nas voltas finais, quando os adversários enfrentaram degradação severa. A vitória consolida a Ferrari na liderança do WEC e aumenta a confiança para Le Mans.', 
	'img-noticia/23-wec-spa-win.png', '2026-05-24', 8, 1);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'Hyundai domina rally de terra na Grécia com novo pacote de suspensão', 
	'A equipe coreana explorou ao máximo as irregularidades do terreno, mantendo velocidade média superior mesmo em seções técnicas. O ajuste fino da suspensão permitiu que os carros absorvessem impactos sem perder tração. O resultado coloca a Hyundai em posição favorável na disputa pelo título de fabricantes.', 
	'img-noticia/24-wrc-greece.jpg', '2026-05-26', 9, 2);

INSERT INTO noticias (titulo_noticia, texto_noticia, imagem_noticia, data_noticia, categoria_id, usuario_id) VALUES
(	'NASCAR Cup Series introduz zona de desaceleração obrigatória em ovais curtos', 
	'Para reduzir colisões em banda e melhorar a segurança, trechos específicos das pistas terão limite de velocidade imposto eletronicamente. A medida gera debate entre pilotos veteranos, que argumentam sobre a perda de espontaneidade, mas é apoiada por equipes focadas na redução de custos de reparo. A implementação será monitorada nas próximas três corridas.', 
	'img-noticia/25-nascar-slow-zone.jpeg', '2026-05-28', 10, 1);

PRAGMA table_info(categorias);
PRAGMA table_info(perfis);
PRAGMA table_info(usuarios);
PRAGMA table_info(noticias);