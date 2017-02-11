 <?php
   /*
 CcronRunT.php

   */
mysql_query("
DELETE a.*
FROM 7c3_posts AS a
   INNER JOIN (
      SELECT post_title, MIN( id ) AS min_id
      FROM 7c3_posts
      WHERE post_type = 'post'
      AND post_status = 'publish'
      GROUP BY post_title
      HAVING COUNT( * ) > 1
   ) AS b ON b.post_title = a.post_title
AND b.min_id <> a.id
AND a.post_type = 'post'
AND a.post_status = 'publish'
");
	 
?>