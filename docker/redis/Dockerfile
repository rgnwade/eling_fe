# FROM redis:latest

# LABEL maintainer="Mahmoud Zalt <mahmoud@zalt.me>"

# ## For security settings uncomment, make the dir, copy conf, and also start with the conf, to use it
# # RUN mkdir -p /usr/local/etc/redis
# # COPY redis.conf /usr/local/etc/redis/redis.conf

# VOLUME /data

# EXPOSE 6379

# # CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
# CMD ["redis-server"]


FROM redis:latest
ARG REDIS_PASSWORD=${REDIS_PASSWORD}

RUN mkdir -p /usr/local/etc/redis
COPY redis.conf /usr/local/etc/redis/redis.conf
RUN sed -i "s/__REDIS_PASSWORD__/${REDIS_PASSWORD}/g" /usr/local/etc/redis/redis.conf

VOLUME /data

EXPOSE 6379

CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
