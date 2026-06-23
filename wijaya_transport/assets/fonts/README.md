Place custom fonts here (not committed to VCS unless you have a license).

If you have the `LamboType` font, add the WOFF/WOFF2 files and then add an `@font-face` rule in `assets/css/style.css` like:

```css
@font-face{
  font-family: 'LamboType';
  src: url('../fonts/LamboType.woff2') format('woff2'), url('../fonts/LamboType.woff') format('woff');
  font-weight: 300 900;
  font-style: normal;
  font-display: swap;
}
```

Then ensure `--base-font` in `assets/css/style.css` uses `LamboType` first.
