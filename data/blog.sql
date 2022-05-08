/* 참고
https://sql-factory.tistory.com/2063
https://blueamor.tistory.com/618

-- 최소일 경우 블로그 테이블만.
-- 블로그, 보드, 코멘트 각각 테이블 필요
-- 제대로 만들 경우: 관리, 유저, 카테고리, 포스트, 코멘트 등등 필요


/* post 포스트
postid 인덱스: 자동증가 정수
wdate 날짜: 타임스탬프
title 타이틀
writer 이름
category 분류: profile, portpolio...
posttype: text, media, link...
file 파일
link 링크
content 내용
tags 태그(차후 추가)
pinned 상단고정
secret 비밀글
replycnt 답글수, 0이면 조회 생략
allow 권한: ????
*/

CREATE TABLE post (
  postid INT AUTO_INCREMENT,
  wdate INT,
  title VARCHAR(80),
  writer VARCHAR(20),
  category CHAR(10),
  posttype CHAR(10),
  file VARCHAR(80),
  link VARCHAR(80),
  content TEXT,
  tags VARCHAR(80),
  pinned BOOLEAN DEFAULT FALSE,
  secret BOOLEAN DEFAULT FALSE,
  replycnt INT DEFAULT 0
  PRIMARY KEY(postid)
);

/* user 유저
userid 아이디
password 비밀번호
username 이름
email 이메일
avatar 아바타
link 링크
usergroup 권한그룹: admin, user
*/

CREATE TABLE user (
  userid CHAR(20) NOT NULL,
  password BLOB,
  nickname VARCHAR(20),
  email VARCHAR(30),
  avatar VARCHAR(80),
  link VARCHAR(80),
  usergroup CHAR(10) DEFAULT 'user',
  PRIMARY KEY(userid)
);

/*
thread 쓰레드
  threadid 쓰레드 인덱스
  wdate 작성일
  userid 작성자 id
  nickname 작성자 이름
  content 본문
  postid 포스트id (값이 0 이면 일반 게시물로 간주)
  pinned 최상위 표시
  secret 비밀글, 부모가 비밀일 경우 자동으로 적용, 이외 선택.
  replycnt 답글수, 0이면 조회 생략
*/

CREATE TABLE thread (
  threadid INT AUTO_INCREMENT,
  wdate INT,
  title VARCHAR(80),
  userid CHAR(20),
  nickname VARCHAR(20),
  content TEXT,
  postid INT DEFAULT 0,
  pinned BOOLEAN DEFAULT FALSE,
  secret BOOLEAN DEFAULT FALSE,
  replycnt INT DEFAULT 0
  PRIMARY KEY(threadid)
);

INSERT INTO thread 
(wdate, userid, nickname, title, content)
VALUES
(UNIX_TIMESTAMP(), 'gyuholee', 'GyuhoLee', 
'게시물 제목 게시물 제목',
'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem sint, fugit eveniet esse doloremque enim delectus itaque debitis voluptatem asperiores voluptatum nostrum tenetur quod libero quo nesciunt dolor modi in!
 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem sint, fugit eveniet esse doloremque enim delectus itaque debitis voluptatem asperiores voluptatum nostrum tenetur quod libero quo nesciunt dolor modi in!
 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem sint, fugit eveniet esse doloremque enim delectus itaque debitis voluptatem asperiores voluptatum nostrum tenetur quod libero quo nesciunt dolor modi in!
 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem sint, fugit eveniet esse doloremque enim delectus itaque debitis voluptatem asperiores voluptatum nostrum tenetur quod libero quo nesciunt dolor modi in!');

/*
reply 답글
  replyid 답글 인덱스
  wdate 작성일
  userid 작성자 id
  nickname 작성자 이름
  content 본문 (280자 제한)
  threadid 쓰레드id
  secret 비밀글, 부모가 비밀일 경우 자동으로 적용.
*/

CREATE TABLE reply (
  replyid INT AUTO_INCREMENT,
  wdate INT,
  userid CHAR(20),
  nickname VARCHAR(20),
  content VARCHAR(280),
  threadid INT,
  secret BOOLEAN DEFAULT FALSE,
  PRIMARY KEY(replyid)
);

INSERT INTO reply 
(wdate, userid, nickname, threadid, content)
VALUES
(UNIX_TIMESTAMP(), 'gyuholee', 'GyuhoLee', 64,
'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem sint, fugit eveniet esse doloremque enim delectus itaque debitis voluptatem asperiores voluptatum nostrum tenetur quod libero quo nesciunt dolor modi in!
 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem sint, fugit eveniet esse doloremque enim delectus itaque debitis voluptatem asperiores voluptatum nostrum tenetur quod libero quo nesciunt dolor modi in!
 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem sint, fugit eveniet esse doloremque enim delectus itaque debitis voluptatem asperiores voluptatum nostrum tenetur quod libero quo nesciunt dolor modi in!
 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem sint, fugit eveniet esse doloremque enim delectus itaque debitis voluptatem asperiores voluptatum nostrum tenetur quod libero quo nesciunt dolor modi in!');

