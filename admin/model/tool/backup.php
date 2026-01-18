<?php
class ModelToolBackup extends Model {
	public function restore($sql) {
		foreach (explode(";\n", $sql) as $sql) {
			$sql = trim($sql);

			if ($sql) {
				$this->db->query($sql);
			}
		}

		$this->cache->delete('*');
	}

	public function getTables() {
		$table_data = array();

		$query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");

		foreach ($query->rows as $result) {
			if (utf8_substr($result['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
				if (isset($result['Tables_in_' . DB_DATABASE])) {
					$table_data[] = $result['Tables_in_' . DB_DATABASE];
				}
			}
		}

		return $table_data;
	}

	public function backup($tables) {
		$output = '';

		foreach ($tables as $table) {
			if (DB_PREFIX) {
				if (strpos($table, DB_PREFIX) === false) {
					$status = false;
				} else {
					$status = true;
				}
			} else {
				$status = true;
			}

			if ($status) {
				$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

				$query = $this->db->query("SELECT * FROM `" . $table . "`");

				foreach ($query->rows as $result) {
					$fields = '';

					foreach (array_keys($result) as $value) {
						$fields .= '`' . $value . '`, ';
					}

					$values = '';

					foreach (array_values($result) as $value) {
						$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
						$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
						$value = str_replace('\\', '\\\\',	$value);
						$value = str_replace('\'', '\\\'',	$value);
						$value = str_replace('\\\n', '\n',	$value);
						$value = str_replace('\\\r', '\r',	$value);
						$value = str_replace('\\\t', '\t',	$value);			

						$values .= '\'' . $value . '\', ';
					}

					$output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
				}

				$output .= "\n\n";
			}
		}

		return $output;	
	}

	public function getbillowner_ids() {
		$sql = "SELECT `bill_id`, `id` FROM `" . DB_PREFIX . "bill_owner` WHERE `transaction_type` = '2' "; 
		$sql .= " GROUP BY `bill_id` ORDER BY `bill_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbill_ids($bill_id) {
		$sql = "SELECT `bill_id`, `transaction_id` FROM `" . DB_PREFIX . "bill` WHERE `bill_id` = '".(int)$bill_id."' "; 
		$sql .= " ORDER BY `transaction_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function delete_transaction($transaction_id) {
		$sql = "DELETE FROM `" . DB_PREFIX . "transaction` WHERE `transaction_id` = '".(int)$transaction_id."' "; 
		//echo $sql;exit;
		$this->log->write($sql);
		$this->db->query($sql);
	}

	public function delete_bill($bill_id) {
		$sql = "DELETE FROM `" . DB_PREFIX . "bill` WHERE `bill_id` = '".(int)$bill_id."' "; 
		//echo $sql;exit;
		$this->log->write($sql);
		$this->db->query($sql);
	}

	public function delete_bill_owner($bill_id) {
		$sql = "DELETE FROM `" . DB_PREFIX . "bill_owner` WHERE `bill_id` = '".(int)$bill_id."' "; 
		//echo $sql;exit;
		$this->log->write($sql);
		$this->db->query($sql);
	}

	public function gethorseowner_ids() {
		$sql = "SELECT o.owner_id, ho.horse_id FROM `" . DB_PREFIX . "owner` o LEFT JOIN `" . DB_PREFIX . "horse_owner` ho ON (ho.owner=o.owner_id) WHERE o.`transaction_type` = '2' "; 
		$sql .= " ORDER BY o.`owner_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function delete_horse($horse_id) {
		$sql = "DELETE FROM `" . DB_PREFIX . "horse` WHERE `horse_id` = '".(int)$horse_id."' "; 
		$sql1 = "DELETE FROM `" . DB_PREFIX . "horse_owner` WHERE `horse_id` = '".(int)$horse_id."' "; 
		//echo $sql;exit;
		$this->log->write($sql);
		$this->log->write($sql1);
		$this->db->query($sql);
		$this->db->query($sql1);
	}

	public function delete_owner($owner_id) {
		$sql = "DELETE FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		//echo $sql;exit;
		$this->log->write($sql);
		$this->db->query($sql);
	}
}
?>
