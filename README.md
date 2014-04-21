#Git WebHook

WebHooks to use on a remote server. This work is based on [arielcr web-hooks](https://github.com/arielcr/web-hooks), currently tailored to meet POST hook JSON from bitbucket.

##Installation

1. Clone the repo: `git clone https://github.com/rhapsodixx/web-hooks.git`
2. Upload the __web-hooks__ folder to your site root

##How To Use

##### Update Server WebHook
This webhook will automatically call `git pull` everytime you push to your bitbucket repository. If directory of your repository is not exist, it will call `git clone` with ssh.

1. Go to __[]Your Repo Name]__ -> __[Administration]__ -> __[Hooks]__ 
2. Select __[POST]__ from available hook and add hook
3. Place the URL with `http://yoursitedomain.com/web-hooks/update-server.php`
3. Make sure your deployment server ssh key is already on __[Deployment Keys]__ list at your repository administration
4. Pull/Clone repository will be under `http://yoursitedomain.com/your-repo-name`

For every repo there is a log file located in the __logs__ folder indicating all the commits made for every repo. Be sure that this folder is writable by the web server.