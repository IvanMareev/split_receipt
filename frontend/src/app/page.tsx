"use client";

import { useEffect, useState } from "react";
import {
  Layout,
  Card,
  Avatar,
  Typography,
  Row,
  Col,
  Spin,
  Result,
  Space,
  Tag,
  Button,
} from "antd";
import { ProList } from '@ant-design/pro-components';
import TelegramUser from "../../types/telegramUser";
import useGetCredentials from "../../api/useGetCredantilas";
const { Header, Content, Footer, Sider } = Layout;
const { Title, Text } = Typography;



const dataSource = [
  {
    title: '语雀的天空',
    avatar:
      'https://gw.alipayobjects.com/zos/antfincdn/efFD%24IOql2/weixintupian_20170331104822.jpg',
  },
  {
    title: 'Ant Design',
    avatar:
      'https://gw.alipayobjects.com/zos/antfincdn/efFD%24IOql2/weixintupian_20170331104822.jpg',
  },
  {
    title: '蚂蚁金服体验科技',
    avatar:
      'https://gw.alipayobjects.com/zos/antfincdn/efFD%24IOql2/weixintupian_20170331104822.jpg',
  },
  {
    title: 'TechUI',
    avatar:
      'https://gw.alipayobjects.com/zos/antfincdn/efFD%24IOql2/weixintupian_20170331104822.jpg',
  },
];

export default function Home() {
  const [user, setUser] = useState<TelegramUser | null>(null);
  const [error, setError] = useState<string>("");
  const [expandedRowKeys, setExpandedRowKeys] = useState<readonly Key[]>([]);
  const [token, setToken] = useState<string>('0');

  useEffect(() => {
    const tg = (window as any).Telegram?.WebApp;
    if (!tg) {
      setError("Telegram WebApp SDK не найден");
      return;
    }

    tg.ready();
    const userData = tg.initDataUnsafe;
    if (userData) {
      setUser(userData.user || userData);
    } else {
      setError("Пользователь не найден");
    }

    tg.MainButton.setText("ОК");
    tg.MainButton.show();
    tg.MainButton.onClick(() => tg.close());

    let token1 = useGetCredentials(userData);

    setToken(token1)
  }, []);

  if (error) {
    return <Result status="error" title={error} />;
  }

  if (!user) {
    return (
      <Row justify="center" style={{ marginTop: 80 }}>
        <Spin size="large" />
      </Row>
    );
  }

  return (
    <Layout style={{ minHeight: "100vh" }}>
      <Sider breakpoint="lg" collapsedWidth="0" style={{ background: "#001529" }}>
        <div style={{ color: "#fff", textAlign: "center", padding: 24 }}>
          Sidebar
        </div>
      </Sider>

      <Layout>
        <Header style={{ background: "#fff", padding: "0 24px" }}>
          <Title level={4} style={{ margin: 0 }}>
           gfgf {token} gfgf
          </Title>
        </Header>

        <Content style={{ margin: 24 }}>
          <Row justify="center">
            <Col xs={24} sm={16} md={12} lg={8}>
              <Card
                bordered={false}
                style={{ textAlign: "center", borderRadius: 12 }}
              >
                <Avatar
                  src={user.photo_url}
                  size={96}
                  style={{ marginBottom: 16 }}
                >
                  {user.first_name[0]}
                </Avatar>
                <Title level={3}>
                  {user.first_name} {user.last_name}
                </Title>
                {user.username && (
                  <Text type="secondary">@{user.username}</Text>
                )}
                <div style={{ marginTop: 8 }}>
                  {user.language_code && (
                    <Text>Язык: {user.language_code}</Text>
                  )}
                </div>
                <div style={{ marginTop: 8 }}>
                  {user.is_premium ? (
                    <Text type="success">💎 Premium</Text>
                  ) : (
                    <Text type="warning">💎 Not Premium</Text>
                  )}
                </div>
              </Card>
            </Col>
          </Row>
        </Content>
        

        <Footer style={{ textAlign: "center" }}>
          © {new Date().getFullYear()} Мареев Иван
        </Footer>
      </Layout>
    </Layout>
  );
}
