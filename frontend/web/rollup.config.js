import fs from "fs";
import svelte from 'rollup-plugin-svelte';
import commonjs from '@rollup/plugin-commonjs';
import alias from '@rollup/plugin-alias';
import resolve from '@rollup/plugin-node-resolve';
import {terser} from 'rollup-plugin-terser';
import sveltePreprocess from 'svelte-preprocess';
//import typescript from "rollup-plugin-typescript2";
import typescript from "@rollup/plugin-typescript";
import css from 'rollup-plugin-css-only';
import json from "@rollup/plugin-json";
import styles from 'rollup-plugin-styles';

const production = !process.env.ROLLUP_WATCH;

let env = {
	js: 'index.js',
	css: 'index.css',
	path: {
		versionfile: process.cwd() + '/../../var/etc/version',
		out: production ? process.cwd() + '/../../assets/public/~web' : process.cwd() + '/../../var/public/~web',
		entry: process.cwd() + '/src/index.ts',
		fonts: process.cwd() + '/../../assets/public/~fonts'
	}
}

let rollup = {
	verbump: function (filename) {
		return {
			writeBundle() {
				let version = fs.existsSync(filename) ? parseInt(fs.readFileSync(filename)) + 1 : 1;
				fs.writeFileSync(filename, version.toString());
				console.log("build number: " + version + ' (' + filename + ')');
			}
		}
	},

	compiler: function (input, outPath, outJS, outCSS, versionFile, production) {
		return {
			input,
			output: {sourcemap: true, format: 'iife', name: 'app', file: outPath + '/' + outJS},
			plugins: [
				styles({mode: 'emit', url: false}),
				//typescript({check: false}),
				typescript(),
				alias({
					entries: [
						{find: 'src', replacement: process.cwd() + '/src'}
					]
				}),
				json(),
				svelte({
					extensions: [".svelte"],
					emitCss: true,
					preprocess: sveltePreprocess({sourceMap: !production}),
					compilerOptions: {
						dev: !production,
						cssHash: ({hash, css, name, filename}) => 'Q' + hash(css)
					}
				}),
				css({output: outCSS}),
				resolve({
					module: false, // <-- this library is not an ES6 module
					browser: true, // <-- suppress node-specific features
				}),
				commonjs(),
				this.verbump(versionFile),
				production && terser()
			]
		}
	}
}


export default rollup.compiler(env.path.entry, env.path.out, env.js, env.css, env.path.versionfile, production);