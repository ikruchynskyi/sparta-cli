FROM php:7.4-cli

WORKDIR /app
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN apt-get -y update && apt-get -y install --no-install-recommends openssh-client=1:8.4p1-5+deb11u1 git=1:2.30.2-1

# Configure SSH client
RUN mkdir -p "$HOME/.ssh" \
  && echo "Host *.magento.cloud *.magentosite.cloud" > "$HOME/.ssh/config" \
  && echo "  Include $HOME/.magento-cloud/ssh/*.config" >> "$HOME/.ssh/config" \
  && echo "  StrictHostKeyChecking no" >> "$HOME/.ssh/config" \
  && echo "  UserKnownHostsFile /dev/null" >> "$HOME/.ssh/config" \
  && echo "Host *" >> "$HOME/.ssh/config"

RUN curl -sS https://accounts.magento.cloud/cli/installer | php
