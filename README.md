# datosmujer.cl — WordPress

Snapshot versionado del sitio WordPress de **datosmujer.cl**. Este repo existe para versionar el código del sitio y hacer deploy controlado.

## Qué contiene este repo

- **Raíz de WordPress**: `index.php`, `wp-*.php`, `.htaccess`, etc.
- **`wp-content/`**: tema y plugins.

## Qué NO se versiona (a propósito)

| Excluido | Motivo |
|---|---|
| `wp-admin/`, `wp-includes/` | Núcleo de WordPress (vendor). Restaurar con una instalación limpia: `wp core download --version=6.9.4`. |
| `wp-content/uploads/` | Media y archivos subidos. No es código. |
| `wp-config.php` | Contiene credenciales. **Nunca** va al repo. |
| `*.sql`, `_db_backup/` | Dump de la base de datos: contiene datos personales. Vive fuera del repo. |
| `wp-content/cache/`, `wflogs/`, `upgrade*/` | Cache / logs / temporales regenerables. |

## Base de datos

El respaldo de la base (prefijo `wprp_`) vive **fuera de este repo**, en backup local.

## Deploy (CI/CD)

Deploy **manual** por FTPS a `/public_html/` vía GitHub Actions.

1. GitHub → pestaña **Actions** → workflow **"Deploy datosmujer.cl (FTPS manual)"** → **Run workflow**.
2. Dejar `dry_run` en **true** la primera vez para ver qué subiría sin tocar el sitio.
3. Si el plan se ve bien, correr de nuevo con `dry_run` en **false**.

### Secrets requeridos (Settings → Secrets and variables → Actions)

Los valores concretos (servidor FTPS, usuario, contraseña) se guardan en GitHub Secrets, no en este repo:

| Secret | Descripción |
|---|---|
| `FTP_SERVER` | Host FTPS del hosting (debe coincidir con el certificado TLS). |
| `FTP_USERNAME` | Usuario FTP/cPanel. |
| `FTP_PASSWORD` | Contraseña FTP/cPanel. |
