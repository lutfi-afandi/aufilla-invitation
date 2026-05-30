const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    
    // Open the URL
    await page.goto('http://127.0.0.1:8000/lutfi-6a1a8882adc1a?to=Azizah', { waitUntil: 'networkidle0' });
    
    // Evaluate if the button exists and get its bounding box
    const buttonInfo = await page.evaluate(() => {
        const btn = document.getElementById('qr-btn');
        if (!btn) return { exists: false };
        
        const rect = btn.getBoundingClientRect();
        const styles = window.getComputedStyle(btn);
        
        return {
            exists: true,
            visible: btn.offsetParent !== null || styles.display !== 'none',
            display: styles.display,
            visibility: styles.visibility,
            opacity: styles.opacity,
            zIndex: styles.zIndex,
            rect: {
                top: rect.top,
                right: rect.right,
                bottom: rect.bottom,
                left: rect.left,
                width: rect.width,
                height: rect.height
            },
            html: btn.outerHTML
        };
    });
    
    console.log(JSON.stringify(buttonInfo, null, 2));
    
    // Click 'Buka Undangan' to hide splash screen
    try {
        await page.click('button[onclick*="splash-screen"]');
        await page.waitForTimeout(1000); // Wait for transition
    } catch(e) {
        // Just in case it's different
        await page.click('#open-btn'); 
        await page.waitForTimeout(1000);
    }
    
    // Take a screenshot
    await page.screenshot({ path: 'debug_qr_screenshot.png', fullPage: true });
    
    await browser.close();
})();
