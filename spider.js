const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch({headless: false, args: ['--no-sandbox']});
    // const browser = await puppeteer.launch({args: ['--no-sandbox']});
    // const browser = await puppeteer.launch();
    const page = await browser.targets();;
    // await page.goto('http://www.baidu.com');
    // await page.screenshot({path: 'example.png'});

    await browser.close();
})();
