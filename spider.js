const puppeteer = require('puppeteer');
(async () => {
    const browserFetcher = puppeteer.createBrowserFetcher();
    const browser = await puppeteer.launch({args: ['--no-sandbox', '--disable-setuid-sandbox']});
    const page = await browser.newPage();
    await page.goto('https://v.qq.com/x/page/e08864ph0yv.html');
    await page.screenshot({path: 'example4.png'});

    await browser.close();
})();
