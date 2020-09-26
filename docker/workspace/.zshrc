export ZSH=$HOME/.oh-my-zsh

ZSH_THEME="robbyrussell"

plugins=(git common-aliases)

source $ZSH/oh-my-zsh.sh
export EDITOR='vim'

export PATH="~/.composer/vendor/bin:/var/www/vendor/bin::$PATH"
