const Svgo = require("svgo");
const fs = require("fs-extra");
const cleanupIDs = require("svgo/plugins/cleanupIDs");
const removeAttrs = require("svgo/plugins/removeAttrs");
const removeDimensions = require("svgo/plugins/removeDimensions");
const removeViewBox = require("svgo/plugins/removeViewBox");
const inlineStyles = require("svgo/plugins/inlineStyles");

function defaultPlugins() {
  // Enable removeAttrs plugin
  // Remove id attribute to prevent conflict with our id
  removeAttrs.active = true;
  removeAttrs.params.attrs = "svg:id";

  // Disable removeViewBox plugin and enable removeDimensions
  // Keep viewBox and remove width & height attribute
  removeViewBox.active = false;
  removeDimensions.active = true;

  // Make all styles inline
  // By definition, a defs sprite is not usable as a CSS sprite
  inlineStyles.active = true;
  inlineStyles.params.onlyMatchedOnce = false;

  return [
    removeDimensions,
    cleanupIDs,
    removeAttrs,
    removeViewBox,
    inlineStyles,
  ];
}

function Svg(config) {
  if (config === null) {
    config = {
      plugins: defaultPlugins()
    };
  }
  this.svgOptimizer = new Svgo(config);
}

Svg.prototype.readSVG = async function(path) {
  const result = await fs.readFile(path);
  return result;
};

Svg.prototype.optimizeSVGRaw = async function(name, content) {
  return await this.svgOptimizer.optimize(content);
};


module.exports = Svg;
