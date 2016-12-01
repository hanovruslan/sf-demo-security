FROM nginx:1.11

VOLUME /var/log/nginx/error
VOLUME /var/log/nginx/access

WORKDIR /etc/nginx/conf.d/

COPY ./src /

#RUN apt-get update && apt-get install -y iftop
