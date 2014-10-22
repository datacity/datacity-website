#VM Debian
server 'datacity-web@192.168.142.132', :app, :web, :primary => true

set :deploy_to, '/home/datacity-web'
set :use_set_permissions, true
set :user, "datacity-web"
