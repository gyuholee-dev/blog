<?php // portpolio.php
$content = <<<HTML

  <section class="post media">
    <!-- <div class="title categoty">분류</div> -->
    <div class="header">
      <div class="title">포스트 제목</div>
      <div class="subcategoty">하위분류</div>
    </div>
    <div class="content">
      <img src="files/localhost_html_0316_hshotel_.png">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae beatae nemo autem voluptates eaque laudantium illo perferendis saepe exercitationem, tempore suscipit facilis quas! Optio, dicta placeat! Ab minus molestiae repellat!
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae beatae nemo autem voluptates eaque laudantium illo perferendis saepe exercitationem, tempore suscipit facilis quas! Optio, dicta placeat! Ab minus molestiae repellat!
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae beatae nemo autem voluptates eaque laudantium illo perferendis saepe exercitationem, tempore suscipit facilis quas! Optio, dicta placeat! Ab minus molestiae repellat!
    </div>
    <div class="footer">
      <div class="tags">태그1, 태그2, 태그3, 태그4</div>
      <div class="info">
        <div class="wdate">2022-03-24 12:33</div>
        <div class="username">이규호</div>
      </div>
    </div>
  </section>

  <section class="post media">
    <div class="header">
      <div class="title">포스트 제목</div>
      <div class="subcategoty">하위분류</div>
    </div>
    <div class="content">
      <img src="files/localhost_html_0318_bakery_.png">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae beatae nemo autem voluptates eaque laudantium illo perferendis saepe exercitationem, tempore suscipit facilis quas! Optio, dicta placeat! Ab minus molestiae repellat!
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae beatae nemo autem voluptates eaque laudantium illo perferendis saepe exercitationem, tempore suscipit facilis quas! Optio, dicta placeat! Ab minus molestiae repellat!
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae beatae nemo autem voluptates eaque laudantium illo perferendis saepe exercitationem, tempore suscipit facilis quas! Optio, dicta placeat! Ab minus molestiae repellat!
    </div>
    <div class="footer">
      <div class="tags">태그1, 태그2, 태그3, 태그4</div>
      <div class="info">
        <div class="wdate">2022-03-24 12:33</div>
        <div class="username">이규호</div>
      </div>
    </div>
  </section>

  <section class="list tile">
    <div class="title xi-bookmark-o">바로가기</div>
    <ul class="tile">
      <li class="item wide">
        <div class="box link active" onclick="location.href='#'">
          <div class="bg" style="background-image:url('images/BI-header_r.png')"></div>
          <div class="post">
            <div class="title">PROFILE</div>
            <div class="summary"></div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box link" onclick="location.href='#'">
          <div class="bg" style="background-image:url('images/slide/images(1).jpg')"></div>
          <div class="post">
            <div class="title">DEVELOPMENT</div>
            <div class="summary"></div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box link" onclick="location.href='http\://www.artstation.com/geoflowerstudio'">
          <div class="bg" style="background-image:url('images/slide/images(2).jpg')"></div>
          <div class="post">
            <div class="title">ART &<br>GRAPHIC</div>
            <div class="summary"></div>
          </div>
        </div>
      </li>
      <li class="item">
        <div class="box link" onclick="location.href='https\://github.com/leegyuho-dev'">
          <div class="bg" style="background-image:url('images/slide/images(3).jpg')"></div>
          <div class="post">
            <div class="title">GITHUB</div>
            <div class="summary"></div>
          </div>
        </div>
      </li>
    </ul>
  </section>

HTML;