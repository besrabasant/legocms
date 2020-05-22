"use strict";

const consola = require("consola");
const mix = require("laravel-mix");
const path = require("path");
const fs = require("fs-extra");
const SVGSpritemapPlugin = require("svg-spritemap-webpack-plugin");
const Svg = require("./svg");

const svgMaster = new Svg();

const sprites = {};

const logger = consola.withTag("SvgSprite");

let name = "svgSprite";

function generateName(name) {
  return name
    .toLowerCase()
    .replace(/\.svg$/, "")
    .replace(/[^a-z0-9-]/g, "-");
}

function registerSymbol(sprite, symbol) {
  sprites[sprite].symbols[symbol.name] = symbol;
}

async function newIcon(svgMaster, file, sprite, name) {
  const rawContent = await svgMaster.readSVG(file);

  const astTree = await svgMaster.optimizeSVGRaw(name, rawContent);

  await registerSymbol(sprite, {
    name,
    path: file,
    info: astTree.info,
  });
}

Config.merge({
  [name]: {
    stylesPath: "resources/sass/generated/_symbols.scss",
    pluginOptions: {
      plainSprite: true,
    },
  },
});

class SvgSprite {
  name() {
    return ["svgSprite", "sprite"];
  }

  dependencies() {
    return ["consola", "svgo-loader", "svgo", "svg-spritemap-webpack-plugin"];
  }

  /**
   * @param {Object} options
   * @param {String} options.iconPath
   * @param {String} options.spriteFilename
   * @param {String} options.stylesPath
   * @param {Object} options.pluginOptions
   */
  register(options) {
    if (typeof options.spriteFilename === "undefined") {
      options.spriteFilename = path.join(Config.fileLoaderDirs.images, "sprite.svg");
    }

    if (typeof options.pluginOptions === "undefined") {
      options.pluginOptions = Object.assign({}, Config.svgSprite.pluginOptions);
    }

    if (typeof options.stylesPath === "undefined") {
        options.stylesPath= Config.svgSprite.stylesPath;
      }

    this.config = {
      iconPath: options.iconPath,
      iconGlob: `${options.iconPath}/**/*svg`,
      stylesPath: options.stylesPath,
      pluginOptions: {
        output: {
          filename: options.spriteFilename,
          chunk: {
            keep: true,
          },
        },
        sprite: {
          prefix: "symbol--",
          generate: {
            title: false,
          },
        },
      },
    };
  }

  webpackPlugins() {
    return new SVGSpritemapPlugin(
      this.config.iconGlob,
      this.config.pluginOptions
    );
  }

  async boot() {
    await this.writeJson();
  }

  async writeJson() {
    let files = await fs.readdirSync(
      path.resolve(Mix.paths.rootPath, this.config.iconPath)
    );

    sprites["symbols"] = {
      name: "symbols",
      symbols: {},
    };

    for (const file of files) {
      let filePath = path.resolve(
        Mix.paths.rootPath,
        this.config.iconPath,
        file
      );
      await newIcon(svgMaster, filePath, "symbols", generateName(file));
    }

    const content = Object.values(sprites).reduce(function(arr, sprite) {
      let spriteSymbols = [];

      Object.values(sprite.symbols).forEach((symbol) => {
        spriteSymbols.push(`$symbol-${symbol.name}: ".symbol--${symbol.name}";
#{$symbol-${symbol.name}} {
    width: ${symbol.info.width}px;
    height: ${symbol.info.height}px;
}`);
      });

      arr = spriteSymbols;

      return arr;
    }, []);

    let outputfile = path.resolve(
      Mix.paths.rootPath,
      this.config.stylesPath
    );

    await fs.writeFile(outputfile, content.join("\r\n"), {
      flag: "w",
    });

    logger.info("Svg styles generated!");
  }
}

mix.extend(name, new SvgSprite());
