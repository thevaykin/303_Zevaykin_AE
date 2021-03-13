#!/bin/bash
chcp 65001

sqlite3 movies_rating.db < db_init.sql

echo "1. Найти все комедии, выпущенные после 2000 года, которые понравились мужчинам (оценка не ниже 4.5). Для каждого фильма в этом списке вывести название, год выпуска и количество таких оценок."
echo "--------------------------------------------------"
sqlite3 movies_rating.db -box -echo "SELECT movies.title AS 'Movie', movies.year AS 'Year', count(*) AS 'Ratings' FROM movies inner join(SELECT * FROM ratings WHERE rating>=4.5) ratings on ratings.movie_id = movies.id inner join(SELECT * FROM users WHERE users.gender = 'male') users on ratings.user_id = users.id WHERE movies.year > 2000 and instr(genres, 'Comedy')>0 GROUP BY title ORDER BY movies.year LIMIT 20;"
echo " "

echo "2. Провести анализ занятий (профессий) пользователей - вывести количество пользователей для каждого рода занятий. Найти самую распространенную и самую редкую профессию посетитетей сайта."
echo "--------------------------------------------------"
sqlite3 movies_rating.db -box -echo "CREATE view "T2" AS SELECT occupation AS 'Profession', count(occupation) AS 'Quantity' FROM users GROUP BY occupation;" 
sqlite3 movies_rating.db -box -echo "SELECT * FROM T2; SELECT Profession, Quantity FROM(SELECT *, max(Quantity)over() AS 'Common', min(Quantity)over() AS 'Rare' FROM T2) WHERE Quantity=Common or Quantity=Rare; drop view T2;"
echo " "


echo "3. Найти все пары пользователей, оценивших один и тот же фильм. Устранить дубликаты, проверить отсутствие пар с самим собой. Для каждой пары должны быть указаны имена пользователей и название фильма, который они ценили."
echo "--------------------------------------------------"
sqlite3 movies_rating.db -box -echo "SELECT DISTINCT  u1.name AS 'User1', u2.name AS 'User2', title AS 'Movie' FROM ratings a, ratings b INNER JOIN movies ON a.movie_id = movies.id INNER JOIN users u1 ON a.user_id = u1.id INNER JOIN users u2 ON b.user_id = u2.id WHERE a.movie_id = b.movie_id and a.user_id < b.user_id  ORDER BY User1, User2 LIMIT 20;"
echo " "

echo "4. Найти 10 самых свежих оценок от разных пользователей, вывести названия фильмов, имена пользователей, оценку, дату отзыва в формате ГГГГ-ММ-ДД."
echo "--------------------------------------------------"
sqlite3 movies_rating.db -box -echo "create view T4 AS select ratings.user_id AS 'userID', ratings.movie_id AS 'movieID', ratings.rating AS 'Rating', max(ratings.timestamp) AS 'Date' FROM ratings group by ratings.user_id order by timestamp desc;"
sqlite3 movies_rating.db -box -echo "select movies.title AS 'Movie', users.name AS 'Name', Rating, date(Date,'unixepoch') AS 'Date' FROM movies, users, T4 where movies.id = movieID and users.id = userID limit 10;drop view T4;"
echo " "

echo "5. Вывести в одном списке все фильмы с максимальным средним рейтингом и все фильмы с минимальным средним рейтингом. Общий список отсортировать по году выпуска и названию фильма. В зависимости от рейтинга в колонке "Рекомендуем" для фильмов должно быть написано "Да" или "Нет"."
echo "--------------------------------------------------"
sqlite3 movies_rating.db -box -echo "CREATE view T5 AS SELECT movies.title AS 'Movie', movies.year AS 'Year', Rating FROM movies inner join(SELECT ratings.movie_id, avg(ratings.rating) AS 'Rating' FROM ratings GROUP BY ratings.movie_id) ratings on ratings.movie_id = movies.id;"
sqlite3 movies_rating.db -box -echo "SELECT Movie, Year, Rating, CASE when MaxRating = Rating then 'Yes' else 'No' end AS Recommend FROM(SELECT *, max(Rating)over() AS 'MaxRating', min(Rating)over() AS 'MinRating' FROM T5) WHERE Rating = MaxRating or Rating = MinRating  ORDER BY Year, Movie LIMIT 20; drop view T5"
echo " "

echo "6. Вычислить количество оценок и среднюю оценку, которую дали фильмам пользователи-женщины в период с 2010 по 2012 год."
echo "--------------------------------------------------"
sqlite3 movies_rating.db -box -echo "CREATE view T6 AS SELECT ratings.rating AS 'Rating', ratings.timestamp AS 'Date' FROM ratings inner join(SELECT users.id, users.gender FROM users WHERE users.gender = 'female') users on ratings.user_id = users.id WHERE date(ratings.timestamp,'unixepoch') between '2010' and '2012' ORDER BY ratings.timestamp;"
sqlite3 movies_rating.db -box -echo "SELECT count(Rating) AS 'Number of ratings', avg(Rating) AS 'Average rating' FROM T6; drop view T6;"
echo " "


echo "7. Составить список фильмов с указанием их средней оценки и места в рейтинге по средней оценке. Полученный список отсортировать по году выпуска и названиям фильмов. В списке оставить первые 20 записей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "CREATE VIEW T7 AS SELECT movies.title AS Movie, movies.year AS Year, Average_rating FROM movies INNER JOIN (SELECT ratings.movie_id, AVG(ratings.rating) AS Average_rating FROM ratings GROUP BY ratings.movie_id) ratings ON ratings.movie_id = movies.id;"
sqlite3 movies_rating.db -box -echo "SELECT Movie, Year, Average_rating, Place FROM (SELECT *, ROW_NUMBER() OVER(ORDER BY Average_rating DESC) AS Place FROM T7) ORDER BY Year, Movie LIMIT 20;drop view T7;"

echo " "

echo "8. Определить самый распространенный жанр фильма и количество фильмов в этом жанре."
echo "--------------------------------------------------"
sqlite3 movies_rating.db -box -echo "CREATE VIEW T8 AS with t(id,gen,rest) AS(SELECT  id, null, genres FROM movies union all SELECT  id, CASE when instr(rest,'|') = 0 then rest else substr(rest,1,instr(rest,'|')-1) end, CASE WHEN instr(rest,'|')=0 then NULL else substr(rest,instr(rest,'|')+1) end FROM t where rest is not null order by id) SELECT  gen AS 'Genres', count(id) AS 'Number' FROM t WHERE gen is not null group by gen;"
sqlite3 movies_rating.db -box -echo "SELECT  Genres AS 'The most widespread genre', max(Number) AS 'Number of films' FROM T8;drop view T8;"
echo " "