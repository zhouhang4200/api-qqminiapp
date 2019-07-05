const puppeteer = require('puppeteer');
(async () => {
    const browserFetcher = puppeteer.createBrowserFetcher();
    // const revisionInfo = await browserFetcher.download('652427');
    const browser = await puppeteer.launch({executablePath: '/usr/lib/chromium-browser/chromium-browser', args: ['--no-sandbox', '--disable-setuid-sandbox']})
    // const browser = await puppeteer.launch({args: ['--no-sandbox', '--disable-setuid-sandbox']});
    const page = await browser.newPage();
    await page.goto('https://www.iqiyi.com/v_19rqvukdic.html#curid=1904213000_d5dcefdf375ac99e02ee082334b9ae53');
    await page.screenshot({path: 'example1.png'});

    await browser.close();
})();
