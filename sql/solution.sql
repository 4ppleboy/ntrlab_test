SELECT
  c.id                                            AS ID,
  MAX(IF(ci.field = 'FirstName', ci.value, NULL)) AS FirstName,
  c.name                                          AS Name,
  MAX(IF(ci.field = 'Phone', ci.value, NULL))     AS Phone
FROM customer c
  LEFT JOIN customerinfo ci ON c.id = ci.id AND ci.field IN ('FirstName', 'Phone')
GROUP BY c.id;

SELECT
  c.id      AS ID,
  ifn.value AS FirstName,
  c.name    AS Name,
  ip.value  AS Phone
FROM customer c
  LEFT JOIN customerinfo ifn ON c.id = ifn.id AND ifn.field IN ('FirstName')
  LEFT JOIN customerinfo ip ON c.id = ip.id AND ip.field IN ('Phone')
ORDER BY c.id;