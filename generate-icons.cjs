/**
 * Generate Android launcher icons from source icon
 * Resizes to all required mipmap densities
 */
const sharp = require('sharp');
const path = require('path');
const fs = require('fs');

const SOURCE = path.join(__dirname, 'assets', 'icon.png');
const ANDROID_RES = path.join(__dirname, 'android', 'app', 'src', 'main', 'res');

// All Android mipmap densities and their sizes
const DENSITIES = [
    { dir: 'mipmap-mdpi',    size: 48 },
    { dir: 'mipmap-hdpi',    size: 72 },
    { dir: 'mipmap-xhdpi',   size: 96 },
    { dir: 'mipmap-xxhdpi',  size: 144 },
    { dir: 'mipmap-xxxhdpi', size: 192 },
];

async function generateIcons() {
    console.log('🎨 Generating Android launcher icons...');

    for (const { dir, size } of DENSITIES) {
        const outDir = path.join(ANDROID_RES, dir);

        // ic_launcher (square)
        await sharp(SOURCE)
            .resize(size, size)
            .png()
            .toFile(path.join(outDir, 'ic_launcher.png'));

        // ic_launcher_round (circle crop)
        const circle = Buffer.from(
            `<svg width="${size}" height="${size}"><circle cx="${size/2}" cy="${size/2}" r="${size/2}" fill="white"/></svg>`
        );
        await sharp(SOURCE)
            .resize(size, size)
            .composite([{ input: circle, blend: 'dest-in' }])
            .png()
            .toFile(path.join(outDir, 'ic_launcher_round.png'));

        // ic_launcher_foreground (larger canvas 108dp equivalent, just the logo)
        const fgSize = Math.round(size * 1.5);
        await sharp(SOURCE)
            .resize(fgSize, fgSize)
            .png()
            .toFile(path.join(outDir, 'ic_launcher_foreground.png'));

        console.log(`  ✓ ${dir} (${size}px)`);
    }

    // Also generate xxxhdpi standalone (already covered above)
    console.log('\n✅ All Android icons generated!');
}

generateIcons().catch(console.error);
