'use strict';

const consola = require("consola");
const mix = require('laravel-mix');
const path = require('path');
const fs = require("fs-extra");
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');
const Svg = require('./svg')

const svgMaster = new Svg();

const sprites = {}

const logger = consola.withTag("SvgSprite")

let name = 'svgSprite';

function generateName(name) {
    return name
      .toLowerCase()
      .replace(/\.svg$/, "")
      .replace(/[^a-z0-9-]/g, "-")
  }
  

function registerSymbol(sprite, symbol) {
    sprites[sprite].symbols[symbol.name] = symbol
}

async function newIcon(svgMaster, file, sprite, name) {

    const rawContent = await svgMaster.readSVG(file)

    const astTree = await svgMaster.optimizeSVGRaw(name, rawContent)
  
    await registerSymbol(sprite, {
      name,
      path: file,
      info: astTree.info,
    })
}

Config.merge({
    [name]: {
        pluginOptions: {
            plainSprite: true
        }
    }
});


class SvgSprite {
    name() {
        return ['svgSprite', 'sprite'];
    }

    dependencies() {
        return ['consola', 'svgo-loader', 'svgo', 'svg-spritemap-webpack-plugin'];
    }

    /**
     * @param {String} iconPath
     * @param {String} [spriteFilename]
     * @param {Object} [pluginOptions]
     */
    register(iconPath, spriteFilename, pluginOptions) {
        
        if (typeof spriteFilename === 'undefined') {
            spriteFilename = path.join(Config.fileLoaderDirs.images, 'sprite.svg');
        }
        
        if (typeof pluginOptions === 'undefined') {
            pluginOptions = Object.assign({}, Config.svgSprite.pluginOptions);
        }

        this.config = {
            iconPath,
            iconGlob: `${iconPath}/**/*svg`,
            pluginOptions: {
                output: {
                    filename: spriteFilename,
                    chunk: {
                        keep: true
                    }
                },
                sprite: {
                    prefix: "symbol--",
                    generate: {
                        title: false 
                    }
                }
            },
        };
    }

    webpackPlugins() {
        return new SVGSpritemapPlugin(this.config.iconGlob, this.config.pluginOptions);
    }

    async boot() {
        await this.writeJson();
    }

    async writeJson() {
        let files = await fs.readdirSync(
            path.resolve(
                Mix.paths.rootPath,
                this.config.iconPath
                )
            );

        sprites['symbols'] = {
            name: "symbols",
            symbols: {}
        }

        for (const file of files) {
            let filePath = path.resolve(Mix.paths.rootPath,this.config.iconPath,file);
            await newIcon(svgMaster, filePath, 'symbols', generateName(file));
        }

        const content = Object.values(sprites).reduce(function(arr, sprite) {
            let spriteSymbols = []
        
            Object.values(sprite.symbols).forEach(symbol => {
              spriteSymbols.push(`$symbol-${symbol.name}: ".symbol--${symbol.name}";
#{$symbol-${symbol.name}} {
    width: ${symbol.info.width}px;
    height: ${symbol.info.height}px;
}`)
            });
        
            arr = spriteSymbols
        
            return arr
          }, []);

        let outputfile =  path.resolve(
            Mix.paths.rootPath,
            "resources/sass/generated/_symbols.scss"
            );

        await fs.writeFile(outputfile, content.join("\r\n"), {
            flag: "w"
        });

        logger.info("Svg styles generated!");

    }
}

mix.extend(name, new SvgSprite());
