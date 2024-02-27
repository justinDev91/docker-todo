# Use Alpine as the base image
FROM alpine:latest

# ARGs to accept database name, user, and password during build time
ENV POSTGRES_DB=main
ENV POSTGRES_PASSWORD=mysecurepassword
ENV POSTGRES_USER=postgres

# Ensure the postgres group and user exist
RUN set -ex; \
  addgroup -S ${POSTGRES_USER} 2>/dev/null || true; \
  adduser -S ${POSTGRES_USER} -G ${POSTGRES_USER} 2>/dev/null || true;

# Ensure the directories where PostgreSQL expects to write/read data exist and are owned by postgres
RUN mkdir -p /var/lib/postgresql/data /run/postgresql && \
  chown -R ${POSTGRES_USER}:${POSTGRES_USER} /var/lib/postgresql/data /run/postgresql

# Switch to the given user before starting PostgreSQL
USER ${POSTGRES_USER}

# Initialize PostgreSQL data directory, create database, and set password
RUN chmod 0700 /var/lib/postgresql/data &&\
  initdb /var/lib/postgresql/data &&\
  echo "host all  all    0.0.0.0/0  md5" >> /var/lib/postgresql/data/pg_hba.conf &&\
  echo "listen_addresses='*'" >> /var/lib/postgresql/data/postgresql.conf &&\
  pg_ctl start -D /var/lib/postgresql/data && \
  psql -U ${POSTGRES_USER} -tc "SELECT 1 FROM pg_database WHERE datname = '${POSTGRES_DB}'" | grep -q 1 || psql -U ${POSTGRES_USER} -c "CREATE DATABASE ${POSTGRES_DB}" &&\
  psql -c "ALTER USER ${POSTGRES_USER} WITH ENCRYPTED PASSWORD '${POSTGRES_PASSWORD}';"

EXPOSE 5432

# Start PostgreSQL
CMD ["postgres", "-D", "/var/lib/postgresql/data"]
