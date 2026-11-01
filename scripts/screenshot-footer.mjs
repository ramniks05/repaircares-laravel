import { chromium } from 'playwright';
import { mkdirSync } from 'fs';

const outDir = 'D:/techrepair/app/storage/screenshots';
mkdirSync(outDir, { recursive: true });

const viewports = [
  { name: 'laptop-1366', width: 1366, height: 768 },
  { name: 'laptop-1280', width: 1280, height: 800 },
  { name: 'mobile-390', width: 390, height: 844 },
];

const browser = await chromium.launch();
for (const vp of viewports) {
  const page = await browser.newPage({ viewport: { width: vp.width, height: vp.height } });
  await page.goto('http://127.0.0.1:8001/', { waitUntil: 'networkidle', timeout: 60000 });
  await page.evaluate(() => {
    localStorage.setItem('city_modal_seen', '1');
    document.getElementById('location-modal')?.classList.remove('open');
  });
  const footer = page.locator('footer.site-footer');
  await footer.scrollIntoViewIfNeeded();
  await page.waitForTimeout(500);
  await footer.screenshot({ path: `${outDir}/footer-${vp.name}.png` });
  await page.screenshot({ path: `${outDir}/full-${vp.name}.png`, fullPage: true });
  await page.close();
}
await browser.close();
console.log('Saved to', outDir);
