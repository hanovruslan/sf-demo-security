#!/usr/bin/env bash
touch_etc_profile () {
    echo export LC_ALL=${locale}
    echo export LANG=${locale}
    echo export LANGUAGE=${locale}
} >> /etc/profile
touch_etc_default_locale () {
    echo export LC_ALL=${locale}
    echo export LANG=${locale}
    echo export LANGUAGE=${locale}
} >> /etc/profile
install_docker_ce () {
    apt -o Dpkg::Options::="--force-confold" install --reinstall locales \
    && apt install -y \
        apt-transport-https \
        ca-certificates \
        curl \
        gnupg2 \
        software-properties-common \
    && curl -fsSL ${gpg_docker_url} | sudo apt-key add - \
    && echo ${apt_source_string} > ${apt_docker_source_path} \
    && apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y --force-yes docker-ce="${docker_engine_version}" \
    && apt-mark hold docker-ce \
    && usermod -aG docker vagrant
}
install_docker_compose () {
    curl -L ${docker_compose_url} > ${docker_compose_path} \
    && chmod +x ${docker_compose_path} \
    && docker-compose version
}
provision () {
    touch_etc_profile \
    && touch_etc_default_locale \
    && install_docker_ce \
    install_docker_compose
}
dpkg -l docker-ce 1>/dev/null 2>&1 || provision