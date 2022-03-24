/* 참고
https://sql-factory.tistory.com/2063
https://blueamor.tistory.com/618

-- 최소일 경우 블로그 테이블만.
-- 블로그, 보드, 코멘트 각각 테이블 필요
-- 제대로 만들 경우: 관리, 유저, 카테고리, 포스트, 코멘트 등등 필요


/* post 포스트
idx 인덱스: 자동증가 정수
wdate 날짜: 타임스탬프
title 타이틀
writer 이름
category 분류: profile, portpolio...
subcategory 하위분류: 일상, 게임...
posttype: text, media, link...
tags 태그 
files 파일
content 내용
*/

CREATE TABLE post (
  idx INT AUTO_INCREMENT,
  wdate INT,
  title VARCHAR(80),
  writer VARCHAR(20),
  category VARCHAR(20),
  subcategory VARCHAR(20),
  posttype VARCHAR(20),
  tags VARCHAR(80),
  files VARCHAR(80),
  content TEXT,
  PRIMARY KEY (idx)
);


INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, tags, files, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '이규호의 프로필',
  'LeeGyuho',
  'profile',
  '',
  'text',
  '프로필',
  'BI-header_r.png',
  'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, tags, files, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'PROFILE',
  'LeeGyuho',
  'profile',
  'link',
  'link',
  '',
  'BI-header_r.png',
  'view.php?page=profile'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, tags, files, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'RESUME',
  'LeeGyuho',
  'profile',
  'link',
  'link',
  '',
  'BI-header_r.png',
  'https://www.jobkorea.co.kr/'
);






INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, tags, files, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '테스트 타이틀',
  'LeeGyuho',
  'diary',
  '일상',
  'text',
  '태그1,태그2,태그3,태그4',
  '1648083930_testfile.jpg',
  'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?'
);


/* board 보드
idx 인덱스: 자동증가 정수
wdate 날짜: 타임스탬프
title 타이틀
writer 이름
email 이메일
home 홈페이지
pass 비밀번호
ip 작성자 IP
category 카테고리: profile, portpolio...
posttype: text, media, link...
tags 태그 
files 파일
content 내용

*/

CREATE TABLE board (

);

/* comment 덧글
idx 인덱스
wdate 날짜
name 이름
pwd 비밀번호
content 내용
비밀
*/
