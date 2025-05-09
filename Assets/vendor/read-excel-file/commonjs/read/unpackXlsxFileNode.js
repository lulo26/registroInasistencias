"use strict";

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = unpackXlsxFile;
var _fs = _interopRequireDefault(require("fs"));
var _stream = _interopRequireWildcard(require("stream"));
var _unzipper = _interopRequireDefault(require("unzipper"));
function _getRequireWildcardCache(nodeInterop) { if (typeof WeakMap !== "function") return null; var cacheBabelInterop = new WeakMap(); var cacheNodeInterop = new WeakMap(); return (_getRequireWildcardCache = function _getRequireWildcardCache(nodeInterop) { return nodeInterop ? cacheNodeInterop : cacheBabelInterop; })(nodeInterop); }
function _interopRequireWildcard(obj, nodeInterop) { if (!nodeInterop && obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(nodeInterop); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (key !== "default" && Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }
function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }
// `unzipper` has a bug when it doesn't include "@aws-sdk/client-s3" package in the `dependencies`
// which causes some "bundlers" throw an error.
// https://github.com/ZJONSSON/node-unzipper/issues/330
//
// One workaround is to install "@aws-sdk/client-s3" package manually, which would still lead to increased bundle size.
// If the code is bundled for server-side-use only, that is will not be used in a web browser,
// then the increased bundle size would not be an issue.
//
// Another workaround could be to "alias" "@aws-sdk/client-s3" package in a "bundler" configuration file
// with a path to a `*.js` file containing just "export default null". But that kind of a workaround would also
// result in errors when using other packages that `import` anything from "@aws-sdk/client-s3" package,
// so it's not really a workaround but more of a ticking bomb.
//
/**
 * Reads XLSX file in Node.js.
 * @param  {(string|Stream)} input - A Node.js readable stream or a path to a file.
 * @return {Promise} Resolves to an object holding XLSX file entries.
 */
function unpackXlsxFile(input) {
  // XLSX file is a zip archive.
  // The `entries` object stores the files
  // and their contents from this XLSX zip archive.
  var entries = {};
  var stream = input instanceof _stream["default"] ? input : input instanceof Buffer ? _stream.Readable.from(input) : _fs["default"].createReadStream(input);
  return new Promise(function (resolve, reject) {
    var entryPromises = [];
    stream
    // This first "error" listener is for the original stream errors.
    .on('error', reject).pipe(_unzipper["default"].Parse())
    // This second "error" listener is for the unzip stream errors.
    .on('error', reject).on('close', function () {
      return Promise.all(entryPromises).then(function () {
        return resolve(entries);
      });
    }).on('entry', function (entry) {
      var contents = '';
      // To ignore an entry: `entry.autodrain()`.
      entryPromises.push(new Promise(function (resolve) {
        // It's not clear what encoding are the files inside XLSX in.
        // https://stackoverflow.com/questions/45194771/are-xlsx-files-utf-8-encoded-by-definition
        // For example, for XML files, encoding is specified at the top node:
        // `<?xml version="1.0" encoding="UTF-8"/>`.
        //
        // `unzipper` supports setting encoding when reading an `entry`.
        // https://github.com/ZJONSSON/node-unzipper/issues/35
        // https://gitlab.com/catamphetamine/read-excel-file/-/issues/54
        //
        // If the `entry.setEncoding('utf8')` line would be commented out,
        // there's a `nonAsciiCharacterEncoding` test that wouldn't pass.
        //
        entry.setEncoding('utf8');
        //
        entry.on('data', function (data) {
          return contents += data.toString();
        }).on('end', function () {
          return resolve(entries[entry.path] = contents);
        });
      }));
    });
  });
}
//# sourceMappingURL=unpackXlsxFileNode.js.map