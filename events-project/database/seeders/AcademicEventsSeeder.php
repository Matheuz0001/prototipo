<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\InscriptionType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AcademicEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Busca ou cria o Organizador
        $organizer = User::where('user_type_id', 2)->first();

        if (!$organizer) {
            $organizer = User::create([
                'name'              => 'Organizador Master',
                'email'             => 'organizador@patio.com',
                'password'          => Hash::make('password'),
                'user_type_id'      => 2,
                'email_verified_at' => now(),
            ]);
        }

        $events = [

            // ─────────────────────────────────────────────────────────────
            // 1. Congresso Brasileiro de Inteligência Artificial
            // ─────────────────────────────────────────────────────────────
            [
                'event' => [
                    'user_id'               => $organizer->id,
                    'title'                 => 'Congresso Brasileiro de Inteligência Artificial',
                    'description'           => "O Congresso Brasileiro de Inteligência Artificial (CBIA 2026) é o maior encontro científico dedicado à IA no Brasil, reunindo pesquisadores, professores, profissionais da indústria e estudantes de todo o país e do exterior.\n\nEste ano, o evento acontece no formato híbrido (presencial + online) e contará com mais de 40 palestrantes nacionais e internacionais, 120 trabalhos científicos selecionados, 6 minicursos práticos e 3 mesas-redondas temáticas.\n\n🎯 Temas de destaque:\n• Machine Learning e Deep Learning avançado\n• Processamento de Linguagem Natural (NLP) e LLMs\n• IA Generativa: oportunidades e riscos\n• Ética, viés e regulamentação de sistemas de IA\n• IA aplicada à saúde, agronegócio e cidades inteligentes\n• Visão Computacional e robótica autônoma\n\n📋 Formatos aceitos para submissão:\n• Artigo completo (até 10 páginas)\n• Resumo expandido (até 4 páginas)\n• Pôster científico\n\nTodos os trabalhos aprovados serão publicados nos Anais do CBIA 2026 com ISBN e indexados na base SBC Open Lib.\n\n🏆 Premiação: Os 3 melhores trabalhos receberão o Prêmio CBIA de Excelência Científica.\n\nNão perca a oportunidade de apresentar suas pesquisas, conectar-se com líderes da área e impulsionar sua carreira na ciência da computação!",
                    'location'              => 'Centro de Convenções Ulysses Guimarães – Brasília, DF',
                    'event_date'            => now()->addDays(65)->setTime(8, 0),
                    'registration_deadline' => now()->addDays(40),
                    'registration_fee'      => 0.00,
                    'max_participants'      => 800,
                    'pix_key'               => 'cbia2026@congressoia.com.br',
                    'cover_image_path'      => 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?q=80&w=1200',
                ],
                'inscription_types' => [
                    [
                        'type'                 => 'Ouvinte',
                        'price'                => 180.00,
                        'allow_work_submission' => false,
                    ],
                    [
                        'type'                 => 'Autor',
                        'price'                => 280.00,
                        'allow_work_submission' => true,
                    ],
                ],
            ],

            // ─────────────────────────────────────────────────────────────
            // 2. Simpósio Nacional de Ciência de Dados e Big Data
            // ─────────────────────────────────────────────────────────────
            [
                'event' => [
                    'user_id'               => $organizer->id,
                    'title'                 => 'Simpósio Nacional de Ciência de Dados e Big Data',
                    'description'           => "O Simpósio Nacional de Ciência de Dados e Big Data (SNCDB 2026) é um fórum científico de alto nível que reúne especialistas, pesquisadores e praticantes na interseção entre ciência de dados, engenharia de dados e análise de negócios.\n\nO evento promove a troca de conhecimento entre academia e indústria, apresentando casos de uso reais, metodologias inovadoras e os mais recentes avanços em tecnologias de processamento e análise de grandes volumes de dados.\n\n📊 Eixos temáticos:\n• Arquiteturas de Data Lake e Data Lakehouse\n• Pipelines de dados em tempo real (Kafka, Spark Streaming)\n• Data Governance e qualidade de dados\n• Análise preditiva e modelos estatísticos avançados\n• Visualização de dados e storytelling com dados\n• DataOps, MLOps e engenharia de features\n• Privacidade de dados e conformidade com a LGPD\n\n📝 Modalidades de trabalho:\n• Artigo técnico-científico completo (6 a 12 páginas – ABNT)\n• Relato de experiência industrial (4 a 8 páginas)\n• Resumo de pôster (2 páginas)\n\nTodos os artigos aprovados passarão por revisão duplo-cega e serão publicados nos Anais Eletrônicos do SNCDB 2026.\n\n💼 Workshops pré-evento (dia anterior): Apache Spark do Zero ao Avançado | Python para Análise de Dados | Dashboard com Power BI e Tableau.",
                    'location'              => 'Auditório Central – UFMG, Belo Horizonte, MG',
                    'event_date'            => now()->addDays(80)->setTime(9, 0),
                    'registration_deadline' => now()->addDays(55),
                    'registration_fee'      => 0.00,
                    'max_participants'      => 500,
                    'pix_key'               => 'sncdb.financeiro@ufmg.br',
                    'cover_image_path'      => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1200',
                ],
                'inscription_types' => [
                    [
                        'type'                 => 'Ouvinte',
                        'price'                => 150.00,
                        'allow_work_submission' => false,
                    ],
                    [
                        'type'                 => 'Autor',
                        'price'                => 250.00,
                        'allow_work_submission' => true,
                    ],
                ],
            ],

            // ─────────────────────────────────────────────────────────────
            // 3. Semana de Pesquisa em Engenharia de Software
            // ─────────────────────────────────────────────────────────────
            [
                'event' => [
                    'user_id'               => $organizer->id,
                    'title'                 => 'Semana de Pesquisa em Engenharia de Software',
                    'description'           => "A Semana de Pesquisa em Engenharia de Software (SPES 2026) é um evento científico organizado pelo Departamento de Computação em parceria com os grupos de pesquisa em Qualidade de Software, Métodos Ágeis e Arquitetura de Sistemas.\n\nO evento tem como objetivo fomentar a produção e divulgação de pesquisas nas diversas subáreas da Engenharia de Software, criando um espaço de debate qualificado entre alunos de graduação, pós-graduação e pesquisadores sênior.\n\n🛠️ Trilhas temáticas:\n• Métodos ágeis: Scrum, Kanban e SAFe em escala\n• Qualidade de software: testes, métricas e revisão de código\n• Arquitetura de microsserviços e sistemas distribuídos\n• DevSecOps: segurança integrada ao pipeline de desenvolvimento\n• Engenharia de Requisitos e modelagem UML/SysML\n• Manutenção e refatoração de sistemas legados\n• Desenvolvimento Low-Code e No-Code: perspectivas científicas\n\n📄 Submissão de trabalhos:\nOs participantes podem submeter trabalhos nas modalidades artigo completo (até 8 páginas) ou resumo expandido (até 3 páginas), seguindo o template da SBC. A revisão será realizada por membros do comitê de programa.\n\n🎓 Certificado de participação e de apresentação emitidos digitalmente com QR Code de autenticação.",
                    'location'              => 'Laboratório de Inovação (Hub Digital) – Bloco de Computação',
                    'event_date'            => now()->addDays(45)->setTime(8, 30),
                    'registration_deadline' => now()->addDays(25),
                    'registration_fee'      => 0.00,
                    'max_participants'      => 300,
                    'pix_key'               => 'spes2026@dep.computacao.edu.br',
                    'cover_image_path'      => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=1200',
                ],
                'inscription_types' => [
                    [
                        'type'                 => 'Ouvinte',
                        'price'                => 80.00,
                        'allow_work_submission' => false,
                    ],
                    [
                        'type'                 => 'Autor',
                        'price'                => 130.00,
                        'allow_work_submission' => true,
                    ],
                ],
            ],

            // ─────────────────────────────────────────────────────────────
            // 4. Conferência Internacional de Cibersegurança
            // ─────────────────────────────────────────────────────────────
            [
                'event' => [
                    'user_id'               => $organizer->id,
                    'title'                 => 'Conferência Internacional de Cibersegurança',
                    'description'           => "A Conferência Internacional de Cibersegurança (CIC 2026) é o principal evento da área de segurança da informação do hemisfério sul, reunindo especialistas globais, agências governamentais, forças armadas, setor financeiro e pesquisadores acadêmicos.\n\nCom um formato imersivo e de alto impacto, a CIC 2026 traz as ameaças mais recentes, estratégias de defesa de última geração e pesquisas pioneiras que definem o futuro da segurança digital.\n\n🔐 Tópicos de pesquisa:\n• Criptografia pós-quântica e segurança em computação quântica\n• Análise forense digital e resposta a incidentes\n• Segurança em ambientes de nuvem multi-cloud e edge computing\n• Ataques de ransomware: detecção, mitigação e recuperação\n• Segurança em dispositivos IoT e sistemas embarcados\n• Inteligência de ameaças (CTI) e automação com SOAR\n• Conformidade regulatória: LGPD, GDPR, ISO 27001 e NIST\n• Hacking ético e programas de Bug Bounty\n\n🏅 Trilha de Competição CTF (Capture The Flag):\nParticipantes poderão se inscrever na competição CTF com premiação em dinheiro para as 3 equipes vencedoras.\n\n📝 Submissão de artigos:\nArtigo completo (8 a 16 páginas), Short paper (4 a 6 páginas) e Relato de caso real (4 páginas). Línguas aceitas: Português e Inglês.\n\n✅ Patrocinadores confirmados: Trend Micro, CrowdStrike, Kaspersky, Serpro e CERT.br.",
                    'location'              => 'Centro de Convenções Tecnológicas – São Paulo, SP',
                    'event_date'            => now()->addDays(90)->setTime(9, 0),
                    'registration_deadline' => now()->addDays(60),
                    'registration_fee'      => 0.00,
                    'max_participants'      => 600,
                    'pix_key'               => 'financeiro@cic2026.com.br',
                    'cover_image_path'      => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=1200',
                ],
                'inscription_types' => [
                    [
                        'type'                 => 'Ouvinte',
                        'price'                => 350.00,
                        'allow_work_submission' => false,
                    ],
                    [
                        'type'                 => 'Autor',
                        'price'                => 480.00,
                        'allow_work_submission' => true,
                    ],
                ],
            ],

            // ─────────────────────────────────────────────────────────────
            // 5. Jornada Acadêmica de Computação e Inovação
            // ─────────────────────────────────────────────────────────────
            [
                'event' => [
                    'user_id'               => $organizer->id,
                    'title'                 => 'Jornada Acadêmica de Computação e Inovação',
                    'description'           => "A Jornada Acadêmica de Computação e Inovação (JACI 2026) é o evento anual organizado pelo Centro Acadêmico de Computação com apoio da reitoria e dos laboratórios de pesquisa. Voltada principalmente a alunos de graduação e iniciação científica, a JACI é o espaço ideal para dar os primeiros passos na pesquisa científica e na divulgação de resultados acadêmicos.\n\nO evento acontece em formato presencial e conta com palestras inspiradoras de ex-alunos que construíram carreiras de sucesso na área de tecnologia, além de sessões de apresentação de trabalhos, maratona de programação e feira de projetos.\n\n🚀 Programação completa:\n• Dia 1 – Palestras magnas e painel de ex-alunos\n• Dia 2 – Sessões de apresentação de trabalhos (oral e pôster)\n• Dia 3 – Feira de Projetos e Protótipos + Workshop de LaTeX\n• Dia 4 – Maratona de Programação (individual) + Cerimônia de encerramento\n\n📌 Áreas de submissão:\nEngenharia de Software | Redes e Sistemas Distribuídos | Banco de Dados | IA e Aprendizado de Máquina | Computação Gráfica | Sistemas Embarcados | Jogos Digitais\n\n📝 Modalidades: Artigo completo, Resumo expandido e Projeto de pesquisa em andamento (TCC, IC).\n\n🏆 Premiação: Melhor trabalho de graduação, Melhor pôster e Campeão da maratona.",
                    'location'              => 'Auditório Principal – Campus Central',
                    'event_date'            => now()->addDays(35)->setTime(8, 0),
                    'registration_deadline' => now()->addDays(18),
                    'registration_fee'      => 0.00,
                    'max_participants'      => 400,
                    'pix_key'               => 'jaci.cacomp@universidade.edu.br',
                    'cover_image_path'      => 'https://images.unsplash.com/photo-1475721027187-402ad2989a3b?q=80&w=1200',
                ],
                'inscription_types' => [
                    [
                        'type'                 => 'Ouvinte',
                        'price'                => 0.00,
                        'allow_work_submission' => false,
                    ],
                    [
                        'type'                 => 'Autor',
                        'price'                => 50.00,
                        'allow_work_submission' => true,
                    ],
                ],
            ],

            // ─────────────────────────────────────────────────────────────
            // 6. Fórum de Ética em Inteligência Artificial e Direito Digital
            // ─────────────────────────────────────────────────────────────
            [
                'event' => [
                    'user_id'               => $organizer->id,
                    'title'                 => 'Fórum de Ética em Inteligência Artificial e Direito Digital',
                    'description'           => "O Fórum de Ética em Inteligência Artificial e Direito Digital (FEIADD 2026) é um evento multidisciplinar que reúne pesquisadores de computação, direito, filosofia, sociologia e políticas públicas para debater os impactos éticos, jurídicos e sociais da inteligência artificial e das tecnologias digitais na sociedade contemporânea.\n\nCom um formato de debate aberto e rigor acadêmico, o fórum busca construir pontes entre as ciências exatas, humanas e sociais aplicadas, produzindo conhecimento transdisciplinar e relevante para a formulação de políticas públicas e regulações tecnológicas.\n\n⚖️ Temas centrais:\n• Responsabilidade civil por decisões automatizadas e algoritmos\n• Viés algorítmico e discriminação sistêmica em sistemas de IA\n• Proteção de dados pessoais: LGPD na prática e desafios emergentes\n• Regulação da IA no Brasil: análise do PL 2338/2023\n• IA, trabalho e impactos socioeconômicos da automação\n• Transparência, explicabilidade e auditoria de sistemas de IA\n• Deepfakes, desinformação e responsabilidade plataformas digitais\n• Direitos autorais e IA generativa: o debate jurídico\n\n📝 Submissões aceitas:\nArtigos científicos (4 a 12 páginas), Ensaios acadêmicos (4 a 8 páginas) e Relatos de caso jurídico ou social (4 páginas). Idiomas aceitos: Português, Inglês e Espanhol.",
                    'location'              => 'Online via Microsoft Teams',
                    'event_date'            => now()->addDays(50)->setTime(14, 0),
                    'registration_deadline' => now()->addDays(30),
                    'registration_fee'      => 0.00,
                    'max_participants'      => 1000,
                    'pix_key'               => 'feiadd2026@forum-etica.org.br',
                    'cover_image_path'      => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=1200',
                ],
                'inscription_types' => [
                    [
                        'type'                 => 'Ouvinte',
                        'price'                => 0.00,
                        'allow_work_submission' => false,
                    ],
                    [
                        'type'                 => 'Autor',
                        'price'                => 100.00,
                        'allow_work_submission' => true,
                    ],
                ],
            ],

            // ─────────────────────────────────────────────────────────────
            // 7. Simpósio de Bioinformática e Computação Aplicada à Saúde
            // ─────────────────────────────────────────────────────────────
            [
                'event' => [
                    'user_id'               => $organizer->id,
                    'title'                 => 'Simpósio de Bioinformática e Computação Aplicada à Saúde',
                    'description'           => "O Simpósio de Bioinformática e Computação Aplicada à Saúde (SBCAS 2026) é um evento científico de referência na interface entre ciências da computação e ciências da vida, reunindo pesquisadores, médicos, biólogos, farmacêuticos e cientistas de dados para discutir as mais recentes inovações computacionais aplicadas à saúde e às ciências biológicas.\n\nO simpósio é organizado em parceria com faculdades de medicina, biologia e farmácia, e conta com o apoio de institutos de pesquisa como Fiocruz, Hospital Albert Einstein e Instituto do Câncer.\n\n🧬 Eixos de pesquisa:\n• Análise de sequenciamento genômico de nova geração (NGS)\n• Bioinformática estrutural: predição de proteínas e docking molecular\n• Aprendizado de máquina para diagnóstico por imagem médica\n• Sistemas de apoio à decisão clínica baseados em IA\n• Epidemiologia computacional e modelagem de surtos\n• Prontuário Eletrônico do Paciente (PEP) e interoperabilidade\n• Computação de alta performance (HPC) para simulações biológicas\n• Saúde digital: wearables, telemedicina e apps de saúde\n\n📄 Submissão:\nArtigo completo (8 a 12 páginas), short paper (4 a 6 páginas) e resumo de pôster (2 páginas). Avaliação duplo-cega por comitê científico multidisciplinar.\n\n🎓 Minicursos (inscrição separada): Python para Bioinformática | Análise de dados de RNA-Seq | Machine Learning para imagens de histopatologia.",
                    'location'              => 'Hospital Universitário – Auditório Nobre, Rio de Janeiro, RJ',
                    'event_date'            => now()->addDays(110)->setTime(9, 0),
                    'registration_deadline' => now()->addDays(75),
                    'registration_fee'      => 0.00,
                    'max_participants'      => 450,
                    'pix_key'               => 'sbcas.financeiro@bioinformatica.org.br',
                    'cover_image_path'      => 'https://images.unsplash.com/photo-1576086213369-97a306d36557?q=80&w=1200',
                ],
                'inscription_types' => [
                    [
                        'type'                 => 'Ouvinte',
                        'price'                => 200.00,
                        'allow_work_submission' => false,
                    ],
                    [
                        'type'                 => 'Autor',
                        'price'                => 320.00,
                        'allow_work_submission' => true,
                    ],
                ],
            ],

            // ─────────────────────────────────────────────────────────────
            // 8. Workshop Nacional de Redes, Cloud Computing e IoT
            // ─────────────────────────────────────────────────────────────
            [
                'event' => [
                    'user_id'               => $organizer->id,
                    'title'                 => 'Workshop Nacional de Redes, Cloud Computing e IoT',
                    'description'           => "O Workshop Nacional de Redes, Cloud Computing e IoT (WNRCI 2026) é um evento técnico-científico que reúne pesquisadores, engenheiros de redes, arquitetos de soluções em nuvem e especialistas em Internet das Coisas para apresentar e discutir trabalhos de fronteira nestas áreas convergentes da computação moderna.\n\nCom foco prático e científico, o workshop combina sessões de apresentação de artigos, demonstrações técnicas ao vivo, hands-on labs e painéis de especialistas da indústria.\n\n☁️ Temas de pesquisa:\n• Arquiteturas serverless e FaaS (Function as a Service)\n• Redes definidas por software (SDN) e virtualização de funções (NFV)\n• Computação em névoa (Fog Computing) e Edge Computing\n• Protocolos para IoT: MQTT, CoAP, AMQP e 5G-IoT\n• Segurança e privacidade em ambientes IoT industriais (IIoT)\n• Orquestração de containers: Kubernetes, Docker Swarm e Nomad\n• Interoperabilidade entre plataformas de cloud: AWS, Azure e GCP\n• Redes ópticas e tecnologias de backbone\n• Automação de redes com IA e NetDevOps\n\n📋 Modalidades de submissão:\nArtigo técnico-científico completo (6 a 10 páginas), Relato de experiência de implantação (4 a 6 páginas) e Demonstração técnica com paper de acompanhamento (2 a 4 páginas).\n\n💡 Laboratórios práticos incluídos na inscrição de Autor: Lab AWS para pesquisadores | Criação de solução IoT end-to-end | Deploy com Kubernetes.",
                    'location'              => 'Espaço Maker – Bloco B, Campus Tecnológico – Campinas, SP',
                    'event_date'            => now()->addDays(72)->setTime(8, 0),
                    'registration_deadline' => now()->addDays(48),
                    'registration_fee'      => 0.00,
                    'max_participants'      => 350,
                    'pix_key'               => 'wnrci2026@workshop-redes.com.br',
                    'cover_image_path'      => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=1200',
                ],
                'inscription_types' => [
                    [
                        'type'                 => 'Ouvinte',
                        'price'                => 120.00,
                        'allow_work_submission' => false,
                    ],
                    [
                        'type'                 => 'Autor',
                        'price'                => 220.00,
                        'allow_work_submission' => true,
                    ],
                ],
            ],

        ];

        foreach ($events as $data) {
            // Cria o evento
            $event = Event::create($data['event']);

            // Cria os tipos de inscrição vinculados ao evento
            foreach ($data['inscription_types'] as $inscriptionType) {
                InscriptionType::create(array_merge($inscriptionType, [
                    'event_id' => $event->id,
                ]));
            }
        }

        $this->command->info('✅ 8 eventos acadêmicos completos criados com sucesso!');
        $this->command->info('   Cada evento possui tipos de inscrição: Ouvinte e Autor (com submissão de trabalhos).');
    }
}
