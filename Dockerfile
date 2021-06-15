# Usage: docker build --pull . && (docker run --rm $(docker build -q .) | tar -x)
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
        php7.4-phpdbg php7.4-dev \
        php8.0-phpdbg php8.0-dev \
    && adduser --disabled-password --gecos '' --no-create-home build \
    && mkdir -p /dst \
    && chown build:build /dst

USER build

COPY --chown=build:build . /src

RUN : \
    && cd src \
    && if [ -f configure ]; then echo "Run git clean -fX" >&2; exit 1; fi \
    && scripts/compile --output-dir /dst 5.6 7.0 7.1 7.2 7.3 7.4 8.0 \
    && make clean \
    && (cd /dst && sha256sum timecop_*.so > SHA256SUMS) \
    && cat /dst/SHA256SUMS \
    && ls -l /dst

CMD : \
    && cd /dst \
    && tar -cf - *.so SHA256SUMS | cat
