# Usage: docker run --rm $(docker build -q .) | tar -x
FROM ubuntu:18.04

RUN : \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get update \
    && apt-get install --no-install-recommends -y software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get install --no-install-recommends -y build-essential \
        php5.6-phpdbg php5.6-dev \
        php7.0-phpdbg php7.0-dev \
        php7.1-phpdbg php7.1-dev \
        php7.2-phpdbg php7.2-dev \
        php7.3-phpdbg php7.3-dev \
    && adduser --disabled-password --gecos '' --no-create-home build \
    && mkdir -p /dst \
    && chown build:build /dst

USER build

COPY --chown=build:build . /src

RUN : \
    && cd src \
    && if [ -f configure ]; then echo "Run git clean -fX" >&2; exit 1; fi \
    && scripts/compile 5.6 /dst \
    && scripts/compile 7.0 /dst \
    && scripts/compile 7.1 /dst \
    && scripts/compile 7.2 /dst \
    && scripts/compile 7.3 /dst \
    && make clean \
    && ls -l /dst

CMD : \
    && cd /dst \
    && tar -cf - *.so | cat
