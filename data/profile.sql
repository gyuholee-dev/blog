/*
 프로필 데이터
*/

-- 프로필
INSERT INTO post 
(wdate, title, userid, nickname, category, posttype, file, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '이규호의 프로필',
  'gyuholee',
  'GyuhoLee',
  'profile',
  'text',
  'BI-header_r.png',
  '',
  'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?'
);

---------------------------- 링크 (네개) ----------------------------

INSERT INTO post 
(wdate, title, userid, nickname, category, posttype, file, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'GITHUB',
  'gyuholee',
  'GyuhoLee',
  'profile',
  'link',
  'images(3).jpg',
  'https://github.com/leegyuho-dev',
  '깃허브 링크'
);

INSERT INTO post 
(wdate, title, userid, nickname, category, posttype, file, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'ART & GRAPHIC',
  'gyuholee',
  'GyuhoLee',
  'profile',
  'link',
  'images(2).jpg',
  'https://www.artstation.com/geoflowerstudio',
  '아트스테이션 링크'
);

INSERT INTO post 
(wdate, title, userid, nickname, category, posttype, file, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'DEVELOPMENT',
  'gyuholee',
  'GyuhoLee',
  'profile',
  'link',
  'images(1).jpg',
  'main.php?page=portpolio',
  '포트폴리오 페이지 링크'
);

INSERT INTO post 
(wdate, title, userid, nickname, category, posttype, file, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'PROFILE',
  'gyuholee',
  'GyuhoLee',
  'profile',
  'link',
  'BI-header_r.png',
  'main.php?page=profile',
  '프로필 페이지 링크'
);