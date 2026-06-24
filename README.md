# MC 1934 — Massa I Carni · Site Institucional

Site institucional do restaurante **MC 1934 — Massa I Carni**, localizado em Campos do Jordão, SP. Projeto estático em HTML/CSS/JS puro, sem frameworks ou dependências de build. Backend mínimo em PHP exclusivamente para o formulário de reservas.

---

## Páginas

| Arquivo | URL publicada | Descrição |
|---|---|---|
| `index.html` | `dezenove34.com.br/` | Landing page institucional |
| `bio/index.html` | `dezenove34.com.br/bio/` | Link-in-bio (Instagram) |
| `politica-de-cookies.html` | `dezenove34.com.br/politica-de-cookies.html` | Política de cookies (LGPD) |

---

## Estrutura de arquivos

```
MC1934/
│
├── index.html                  # Landing page principal
├── politica-de-cookies.html    # Página LGPD de cookies
├── reservas.php                # Backend PHP — recebe formulário de reservas
├── .htaccess                   # Bloqueia acesso público ao reservas.csv
├── .gitignore
│
├── bio/
│   └── index.html              # Link-in-bio (página do Instagram)
│
└── assets/
    ├── fonts/
    │   ├── palmore-vintage/    # Palmore Vintage (Light, Regular, Semibold, Bold) — display
    │   └── the-camellia-font/  # The Camellia — script/assinatura
    │
    ├── imgs/                   # Todas as imagens em .webp (otimizadas)
    │   ├── mc-interior.webp
    │   ├── mc-massa.webp
    │   ├── mc-carne.webp
    │   ├── mc-terraco.webp
    │   ├── mc-chef-acao.webp
    │   ├── mc-fachada.webp
    │   ├── mc-burrata.webp
    │   ├── mc-carpaccio.webp
    │   ├── mc-azeite.webp
    │   ├── mc-menu.webp
    │   ├── mc-pizza.webp
    │   ├── compartilhamento.webp  # Imagem de Open Graph (compartilhamento social)
    │   ├── andre.webp             # Foto do Chef André Boccato
    │   ├── serra.webp
    │   └── cap2_1x.webp … cap6_1x.webp  # Capturas de seções
    │
    └── logo/
        ├── DEZENOVE34 PRETO.svg   # Logotipo principal (versão escura)
        ├── 1934-preto.svg          # Ícone "1934" — usado como favicon
        └── 1934 PRETO_1.svg        # Variação do ícone
```

> **Nota:** `reservas.csv` é gerado automaticamente pelo servidor quando a primeira reserva é recebida. Ele não está no repositório (`.gitignore`) e não deve ser commitado, pois contém dados pessoais de clientes.

---

## Sistema de Design

O site usa um design system próprio, controlado por CSS custom properties definidas em cada arquivo.

### Paleta de cores

| Variável | Valor | Uso |
|---|---|---|
| `--carmesim` | `#B22222` | Cor de destaque principal |
| `--carmesim-dark` | `#7A1515` | Hover / variação escura |
| `--marfim` | `#FFEDCE` | Textos e elementos claros |
| `--preto-quente` | `#1A1210` | Fundo principal |
| `--carvao` | `#2C2220` | Fundo alternativo / cards |
| `--off-white` | `#FDF8F0` | Elementos brancos |

### Tipografia

| Fonte | Tipo | Uso |
|---|---|---|
| **Palmore Vintage** | Serif display (local) | Títulos, headings, números decorativos |
| **Lato** | Sans-serif (Google Fonts) | Corpo, legendas, UI |
| **The Camellia** | Script (local) | Nome do restaurante, destaques de assinatura |

As fontes Palmore Vintage e The Camellia são carregadas localmente via `@font-face` a partir de `assets/fonts/`. O Lato é carregado via Google Fonts com `preconnect`.

---

## Funcionalidades

### Landing page (`index.html`)

- **Seções:** Hero, Sobre, Chef, Cardápio (massas, carnes, antipasto), Rooftop, Galeria, Reservas, Rodapé
- **Modal de reservas:** formulário com campos Nome, WhatsApp, Data e Número de pessoas — envia JSON para `reservas.php`
- **Alternância de idioma:** Português / English via atributos `data-pt` / `data-en` nos elementos `.i18n`
- **Cursor customizado:** `.cursor-dot` + `.cursor-ring` com efeito de hover (desativado em touch)
- **Cookie banner:** aparece após 1.8s na primeira visita; persiste escolha no `localStorage` com a chave `mc1934_cookies` (valores: `'all'` ou `'essential'`)

### Link-in-bio (`bio/index.html`)

- Cards com imagens reais do restaurante funcionando como botões de ação
- Links diretos para WhatsApp com mensagens pré-preenchidas por contexto (reserva, cardápio de massas, cardápio de carnes, rooftop)
- Seção de história da marca e pilares
- Links sociais: WhatsApp, Instagram, Google Maps, Site oficial

### Política de Cookies (`politica-de-cookies.html`)

- Página LGPD-compliant (Lei 13.709/2018)
- Tabela de cookies documentados com tipo, finalidade e duração
- Links para gerenciamento de cookies nos principais navegadores
- `<meta name="robots" content="noindex, follow">` — não indexada pelos buscadores

---

## Backend — Formulário de Reservas

### Como funciona

O formulário em `index.html` envia um `POST` com JSON para `reservas.php`. O PHP valida os campos e anexa uma linha ao arquivo `reservas.csv` com separador `;`.

### Campos salvos no CSV

| Campo | Descrição |
|---|---|
| `recebido_em` | Timestamp ISO 8601 (data/hora do servidor) |
| `nome` | Nome do cliente |
| `whatsapp` | Número de WhatsApp |
| `data` | Data pretendida para a reserva |
| `pessoas` | Número de pessoas |

### Segurança

O arquivo `.htaccess` impede que `reservas.csv` seja acessado diretamente pelo navegador:

```apache
<Files "reservas.csv">
  Require all denied
</Files>
```

O CSV só pode ser acessado via painel FTP/File Manager da hospedagem.

---

## Deploy — Hostinger

1. Acesse o **File Manager** ou conecte via **FTP** (FileZilla, etc.)
2. Faça upload de **todos os arquivos e pastas** para `public_html/`
3. Certifique-se que a estrutura final em `public_html/` seja:

```
public_html/
├── index.html
├── politica-de-cookies.html
├── reservas.php
├── .htaccess
├── bio/
│   └── index.html
└── assets/
    ├── fonts/
    ├── imgs/
    └── logo/
```

4. O `reservas.csv` **não precisa ser enviado** — será criado automaticamente pelo servidor quando a primeira reserva for submetida.
5. Certifique-se que o PHP está ativo no plano da Hostinger (está por padrão em todos os planos com hospedagem compartilhada).

---

## Desenvolvimento Local

Para testar o formulário de reservas (PHP), é necessário um servidor local com suporte a PHP:

```bash
# Na raiz do projeto
php -S localhost:3000
```

Acesse `http://localhost:3000` no navegador.

> As páginas HTML puras (`index.html`, `bio/index.html`, `politica-de-cookies.html`) podem ser abertas diretamente no navegador sem servidor. O formulário de reservas retornará erro sem o servidor PHP — isso é esperado em desenvolvimento estático.

---

## Links de Produção

| Destino | URL |
|---|---|
| Site principal | `https://dezenove34.com.br/` |
| Link-in-bio | `https://dezenove34.com.br/bio/` |
| Política de cookies | `https://dezenove34.com.br/politica-de-cookies.html` |
| Instagram | `https://www.instagram.com/mcdezenove34/` |
| WhatsApp | `https://wa.me/5512991455301` |

---

## Observações para Manutenção

- **Trocar imagens:** substituir os arquivos `.webp` em `assets/imgs/` mantendo os mesmos nomes de arquivo. Recomendado manter o formato `.webp` para performance.
- **Atualizar texto:** todos os textos estão inline no HTML. Buscar pelo conteúdo diretamente no arquivo.
- **Idioma inglês:** textos em inglês são definidos no atributo `data-en` dos elementos com classe `.i18n` — não é um sistema de tradução externo.
- **Logo:** os SVGs em `assets/logo/` são vetoriais e podem ser abertos/editados em Illustrator, Figma ou Inkscape.
- **Fontes locais:** Palmore Vintage e The Camellia são fontes licenciadas. A licença do The Camellia está em `assets/fonts/the-camellia-font/Befonts-License.txt`.
