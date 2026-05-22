# MC1934

## Hospedagem Hostinger

Envie os arquivos para a pasta publica da hospedagem, normalmente `public_html`.

O formulario envia os dados para `reservas.php`, que cria/atualiza `reservas.csv` automaticamente.

O arquivo `.htaccess` bloqueia o acesso publico direto ao CSV.

Para testar localmente com PHP:

```bash
php -S localhost:3000
```

Depois acesse `http://localhost:3000`.
