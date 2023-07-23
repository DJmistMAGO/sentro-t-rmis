const mix = require("laravel-mix");
const fs = require("fs");

let getFiles = function (dir) {
    return fs.readdirSync(dir).filter((file) => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

// TODO add the directories here relative to resources/js/
var dirs = [
    "", // for files under js
];
var resPath = "resources/js/";
var pubPath = "public/js/";

dirs.forEach(function (item, index) {
    getFiles(resPath + item).forEach(function (filepath) {
        mix.js(resPath + item + filepath, pubPath + item).version();
    });
});

mix.disableNotifications();
