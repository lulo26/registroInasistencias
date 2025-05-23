import fs from 'fs';
import Stream, { Readable } from 'stream';

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
import unzip from 'unzipper';

/**
 * Reads XLSX file in Node.js.
 * @param  {(string|Stream)} input - A Node.js readable stream or a path to a file.
 * @return {Promise} Resolves to an object holding XLSX file entries.
 */
export default function unpackXlsxFile(input) {
  // XLSX file is a zip archive.
  // The `entries` object stores the files
  // and their contents from this XLSX zip archive.
  var entries = {};
  var stream = input instanceof Stream ? input : input instanceof Buffer ? Readable.from(input) : fs.createReadStream(input);
  return new Promise(function (resolve, reject) {
    var entryPromises = [];
    stream
    // This first "error" listener is for the original stream errors.
    .on('error', reject).pipe(unzip.Parse())
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