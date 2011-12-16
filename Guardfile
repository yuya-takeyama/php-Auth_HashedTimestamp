# A sample Guardfile
# More info at https://github.com/guard/guard#readme

guard 'phpunit', :tests_path => 'tests', :cli => '--colors' do
  watch(%r{^.+Test\.php$})
  watch(%r{^src/(.+)\.php$}) {|m| %Q{tests/#{m[1]}Test.php} }
end
