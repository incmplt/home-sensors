# SensorDB

SensorDBは、複数の RapberryPi に接続した BME280,HM-Z19 センサーの情報を収集し解析するための基本的な仕組みである。
Co2濃度取得の HM-Z19 が無い場合でも、データの記録は可能であり 屋外 では BME280(温度・湿度・気圧)を記録するために RaspberryPi ZERO WHなどを使用することができる。

センサーの値を記録する サーバーは、以下の構成で開発した。

* CentOS 7
* Apache httpd 2.4
* PHP 7.4
* MariaDB (CentOS RPM Package)
* perl (CentOS RPM Package)

特殊なフレームワークを使用しない単純なPHP実装のため、Ubuntu や RaspberryPi などで動作させることも可能である。

## Usage

データを収集するセンサー側の RaspberryPi と 保存するMySQLサーバー側で必要なモジュールは以下の通りである。

### RaspberryPi : Sensor

```text
/opt
  +-- /iot
        +-- bin
             +-- getmac.sh
             +-- config.py : saveSensor.py と共通の設定ファイル
             +-- postSensor.py
```

### SensorDB : ConetOS7

```text
/var
  +-- /www
        +-- html
              +-- /api
              |    +-- postSensor.php
              |
              +-- /lib
                    +-- config.php
                    +-- Database.class.php
                    +-- Debug.class.php
                    +-- SensorDevice.class.php
```

実行に最低限必要なコードは上記の通り。

### Post Sensor data

## Install

RaspberryPi 側のインストールは以下のコマンドを実行する。

```bash
sudo make install
/opt/iot/bin/getmac.sh → wlan0 のMACアドレスが表示されるので記録する
```

SensorDB サーバー側は、以下のコマンドで Web関連コンテンツを配置する

```bash
sudo make sensordb
```

コンテンツが配置できたら、以下のSQLを実行して基本的なデータベースを作成する。

```bash
mysql -u root -p < ./sql/sensordb.sql
mysql -u root -p < ./sql/master.sql
```

### Sensor Node Control

センサーを登録/削除する sensorctl.pl は、Config::Tiny,  DBI, DBD-MySQL などのモジュールを使用する。

```bash
apt install libconfig-tiny-perl
```

postSensor.py を実行する前に Node テーブルに、データを送信する RaspberryPi を登録する。

```bash
sbin/sensorctl -a -n 'nodename' -m 'macaddress'
```

登録してある RaspberryPi を削除するには、以下のコマンドを実行する。

```bash
sbin/sensorctl -d -m 'macaddress'
```

## Licence

[MIT](https://github.com/tcnksm/tool/blob/master/LICENCE)

## Author

* [incmplt](https://www.incmplt.net/)
* [Info Circus,Inc.](https://www.infocircus.jp/)
