/**
 * @file
 * Task: Build.
 */

 /* global module */

module.exports = function (gulp, plugins, options) {
  'use strict';
  plugins.runSequence.options.showErrorStackTrace = false;

  gulp.task('build', function(cb) {
    plugins.runSequence(
      'compile:sass',
      ['minify:css',
        'compile:styleguide'],
      cb);
  });

  gulp.task('build:dev', function(cb) {
    plugins.runSequence(
      'compile:sass',
      ['minify:css',
        'compile:styleguide'],
      cb);
  });
};
