# db-migrations — cambios aplicados en producción (base de datos)

El código del sitio se versiona en este repo, pero **la base de datos vive fuera**
(`*.sql` está en `.gitignore`). Cuando se hace un cambio directo en la DB de
producción, se documenta aquí y, cuando es reproducible, se deja un script
idempotente para poder rehacerlo desde cero.

Cada script es de **un solo uso**: se copia a `public_html/` junto a `wp-load.php`,
se abre con `?token=...`, y se **borra del server** al terminar (no debe quedar
ningún `.php` ejecutable suelto). Después, vaciar la caché (WP Super Cache).

---

## 2026-06-28 — Dropdown "MÁS" + sort de "LO MÁS LEÍDO"

### 1. Dropdown "MÁS" en el menú principal
**Script:** `2026-06-28-menu-mas-dropdown.php` (idempotente, reproducible).

Agrega un ítem `MÁS ▾` al final del menú `td-demo-header-menu` (term_id 56) con
20 categorías ocultas como hijos, y un CSS limpio de 2 columnas en el "CSS
adicional" del Personalizador (marcadores `DM-MAS-START` / `DM-MAS-END`).

- Categorías: Nosotras, Salud, Hijos, Dato Tecno, Tendencias, Dato Pyme, Fitness,
  Casa, Educación, Mascotas, Viajes, Musica, Dato Verde, TV, Columna Datos Mujer,
  Food, Tecnología, Pasatiempos, Cine, Tragos (orden por nº de notas).
- `Dato Tecno` (cat 214) y `Tecnología` (cat 72) son categorías **separadas**,
  ambas incluidas a propósito.
- La categoría `CINE` (cat 2907) se muestra como **"Cine"**.

**Rollback:** correr el script borra/recrea; para eliminar el dropdown, borrar el
ítem `MÁS` y sus hijos en *Apariencia → Menús*, y quitar el bloque
`DM-MAS-START…END` de *Personalizar → CSS adicional*.

**Gotchas (no perder):**
- `wp_update_custom_css_post()` escapa `>` a `&gt;` → el CSS NO usa `>`.
- tagDiv abre el submenú con jQuery `.show()` (mete `display:block` inline) →
  `display:flex` necesita `!important`.

### 2. "LO MÁS LEÍDO" (home) ahora ordena por vistas reales
Cambio puntual en el shortcode tagDiv del bloque LO MÁS LEÍDO de la portada
(post 637): `sort=""` (por fecha) → `sort="popular"` (por `post_views_count`).
Pedido de la clienta: "que la noticia más leída sea la más leída y no la última
publicada". Aplicado por SQL acotado al bloque (no toca ULTIMAS PUBLICACIONES):

```sql
UPDATE wprp_posts
SET post_content = INSERT(
        post_content,
        LOCATE('sort=""', post_content, LOCATE('LO MAS LEIDO', post_content)),
        7, 'sort="popular"')
WHERE ID = 637
  AND LOCATE('LO MAS LEIDO', post_content) > 0
  AND LOCATE('sort=""', post_content, LOCATE('LO MAS LEIDO', post_content)) > 0
  AND LOCATE('sort=""', post_content, LOCATE('LO MAS LEIDO', post_content))
        < LOCATE('ULTIMAS PUBLICACIONES', post_content);
```
**Rollback:** mismo `INSERT` reemplazando `sort="popular"` → `sort=""`.
