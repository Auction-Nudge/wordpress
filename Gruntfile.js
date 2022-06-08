module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
		
		less: {
			wp_css: {
				files: {
					'assets/css/admin.css': 'assets/less/admin.less'
				}
			}	
		},
		
		cssmin: {
			wp_css: {
				files: {
					'assets/css/admin.min.css': 'assets/css/admin.css'
				}
			}
		},

		watch: {
			wp_css: {
				files: ['assets/less/*.less'],
				tasks: ['build_wp_css']
			},
			wp_readme: {
				files: ['readme.txt'],
				tasks: ['build_wp_md']
			}			
		},

		wp_readme_to_markdown: {
			build_wp_md: {
				files: {
					'readme.md': 'readme.txt'
				},
				options: {
					screenshot_url: 'https://ps.w.org/{plugin}/assets/{screenshot}.jpg',
					post_convert: function(content) {
						//Remove unsupported Vimeo tags
						return content.replace(/\[vimeo(.*)\]\n*/g, '');
					}
				}				
			}
		}
  });

	grunt.loadNpmTasks('grunt-contrib-less');  
	grunt.loadNpmTasks('grunt-contrib-cssmin');  
  grunt.loadNpmTasks('grunt-contrib-watch');	
	grunt.loadNpmTasks('grunt-wp-readme-to-markdown');

  grunt.registerTask('default', [
  	'less',
  	'cssmin',
  	'wp_readme_to_markdown',
  	'watch'
  ]);

  grunt.registerTask('build_wp_css', [
   	'less:wp_css',
   	'cssmin:wp_css'
  ]);       

  grunt.registerTask('build_wp_md', [
 		'wp_readme_to_markdown:build_wp_md'
  ]);     
};
