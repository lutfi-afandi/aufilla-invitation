const fs = require('fs');
const https = require('https');
const path = require('path');

const cssUrl = "https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap";

const headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36'
};

https.get(cssUrl, { headers }, (res) => {
    let data = '';
    res.on('data', chunk => data += chunk);
    res.on('end', () => {
        let css = data;
        const urlRegex = /url\((https:\/\/[^)]+)\)/g;
        let match;
        const fontUrls = [];
        
        while ((match = urlRegex.exec(data)) !== null) {
            fontUrls.push(match[1]);
        }
        
        const cssDir = path.join(__dirname, 'public', 'assets', 'vendor', 'css');
        const fontsDir = path.join(__dirname, 'public', 'assets', 'vendor', 'fonts');
        
        if (!fs.existsSync(fontsDir)) fs.mkdirSync(fontsDir, { recursive: true });
        if (!fs.existsSync(cssDir)) fs.mkdirSync(cssDir, { recursive: true });
        
        let downloads = fontUrls.length;
        
        fontUrls.forEach((url, index) => {
            const ext = url.split('.').pop() || 'woff2';
            const filename = `font-${index}.${ext}`;
            const filepath = path.join(fontsDir, filename);
            
            // replace URL in css
            css = css.replace(url, `../fonts/${filename}`);
            
            https.get(url, (fontRes) => {
                const fileStream = fs.createWriteStream(filepath);
                fontRes.pipe(fileStream);
                fileStream.on('finish', () => {
                    fileStream.close();
                    downloads--;
                    if (downloads === 0) {
                        fs.writeFileSync(path.join(cssDir, 'fonts.css'), css);
                        console.log('Fonts downloaded and CSS updated');
                    }
                });
            });
        });
    });
});
