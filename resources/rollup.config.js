const path = require('path');
const fs = require('fs');
import scss from 'rollup-plugin-scss';

const uncompiled = path.resolve(`${__dirname}/uncompiled`);
const build = path.resolve(`${__dirname}/build`);
const thema = path.resolve(`${__dirname}/../`);

export default {
  input: `${uncompiled}/js/index.js`,
  output: {
    file: `${build}/js/bundel.js`,
    format: 'es',
  },
  plugins: [ 
    scss({
      watch: [`${uncompiled}/stijl/`, `${uncompiled}/stijl/**/*`, `${uncompiled}/stijl/style.scss`],
      output: function (styles, styleNodes) {
        fs.writeFileSync('style.css', styles)
      },
      sourceMap: false,
      outFile: '../style.css',
      outputStyle: "compressed"
    }) // will output compiled styles to output.css
  ]  
};