# .bashrc

# Source global definitions
if [ -f /etc/bashrc ]; then
	. /etc/bashrc
fi

# User specific aliases and functions
alias getgit='cd ~/git; for d in $(ls); do if [ -d $d ]; then cd $d; echo "***** $d *****"; git pull; cd ..; fi; done'
alias gofork='cd /opt/ljlgeek/forkljl'
alias verify='sudo vbag git'
alias goplug='cd /usr/lib64/nagios/plugins/'
alias gonag='cd /etc/nagios'
alias agent='SSH_ENV="$HOME/.ssh/environment"; /usr/bin/ssh-agent | sed 's/^echo/#echo/' > "${SSH_ENV}"; chmod 600 "${SSH_ENV}"; . "${SSH_ENV}" > /dev/null; /usr/bin/ssh-add'

## Multiple Knife ENV functions, Ref: https://gist.github.com/bknowles/1314695 ##
 
# knife alias, "prod-foo" for interacting with chef.foo.example.com
  function pfoo {
    ORGNAME=pfoo
    export ORGNAME
    knife "$@"
  }
# knife alias, "dev-foo" for interacting with chef.foo.example.dev
  function dfoo {
    ORGNAME=dfoo
    export ORGNAME
    knife "$@"
  }

# set title 
title() {
  echo -ne "\033]0;"$1"\007"
}

set title $HOSTNAME
