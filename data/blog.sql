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
allow 권한: ????
*/

CREATE TABLE post (
  postid INT AUTO_INCREMENT PRIMARY KEY,
  wdate INT,
  title VARCHAR(80),
  writer VARCHAR(20),
  category VARCHAR(20),
  posttype VARCHAR(20),
  file VARCHAR(80),
  link VARCHAR(80),
  content TEXT,
  tags VARCHAR(80),
  pinned BOOLEAN NOT NULL DEFAULT FALSE
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
  userid VARCHAR(20) NOT NULL PRIMARY KEY,
  password VARCHAR(20),
  nickname VARCHAR(20),
  email VARCHAR(30),
  avatar VARCHAR(80),
  link VARCHAR(80),
  usergroup VARCHAR(20) DEFAULT 'user'
);

/* board 보드
numb 인덱스: 자동증가 정수
wdate 날짜: 타임스탬프
title 타이틀
writer 이름
category 분류: notice, qna, free...
content 내용
secret 비밀글
hits 조회수

*/

CREATE TABLE board (
  numb INT AUTO_INCREMENT PRIMARY KEY,
  category CHAR(10),
  title VARCHAR(80),
  wdate INT,
  userid CHAR(20),
  nickname VARCHAR(20),
  content TEXT,
  secret BOOLEAN DEFAULT 0,
  hit INT DEFAULT 0
);

INSERT INTO board 
(category, title, wdate, userid, nickname, content)
VALUES
('notice', '게시글 제목', UNIX_TIMESTAMP(), 'gyuholee', 'Gyuholee', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque fuga commodi obcaecati delectus quaerat earum ad odit ducimus placeat doloremque corporis modi quia, harum cum exercitationem, veritatis velit aliquid nam.');

/* comment 덧글
commentid 인덱스
wdate 날짜
name 이름
pwd 비밀번호
content 내용
비밀
*/
