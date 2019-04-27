Create `~/.bash_aliases` file. Copy following to it;

     alias dcomposer='docker-compose run --rm composer '
     alias dphp='docker-compose run --rm php '
     alias dgrunt='docker-compose run --rm grunt '
     alias dnpm='docker-compose run --rm npm '
     alias dnode='docker-compose run --rm node '

Edit `~/.bashrc` file and add following line;

    # Add bash aliases
    if [ -f ~/.bash_aliases ]; then
        source ~/.bash_aliases
    fi

# Build locally

    docker-compose build
    docker-compose up -d

# Install Dependencies

    dphp composer install
