# Ref: https://gist.github.com/bknowles/1314695
log_level                :info
log_location             STDOUT
node_name                'chefguest'
client_key               "/home/ljl/.chef/chefguest.pem"
if ENV['ORGNAME'] == 'pfoo'
  chef_server_url "https://chef1.foo.example.com/organizations/foo"
elsif ENV['ORGNAME'] == 'dfoo'
  chef_server_url 'https://chef2.foo.example.dev/organizations/foo'
else
  chef_server_url  'https://chef.foo.example.dev/organizations/foo'
end
cache_type               'BasicFile'
cache_options( :path => "/home/ljl/.chef/checksums" )
#cache_options( :path => "#{ENV['HOME']}/.chef/checksums" )
verify_api_cert        false
ssl_verify_mode        :verify_none
ssl_verify_peer        false
