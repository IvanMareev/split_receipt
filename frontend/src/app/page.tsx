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
const { Header, Content, Footer, Sider } = Layout;
const { Title, Text } = Typography;

interface TelegramUser {
  id: number;
  first_name: string;
  last_name?: string;
  username?: string;
  language_code?: string;
  is_premium?: boolean;
  photo_url?: string;
}


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
            Дели и плати
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
        <Content style={{ margin: 24 }}>
          <Row justify="start">
            <ProList<{ title: string }>
              rowKey="title"
              headerTitle="支持展开的列表"
              toolBarRender={() => {
                return [
                  <Button key="3" type="primary">
                    新建
                  </Button>,
                ];
              }}
              expandable={{ expandedRowKeys, onExpandedRowsChange: setExpandedRowKeys }}
              dataSource={dataSource}
              metas={{
                title: {},
                subTitle: {
                  render: () => {
                    return (
                      <Space size={0}>
                        <Tag color="blue">Ant Design</Tag>
                        <Tag color="#5BD8A6">TechUI</Tag>
                      </Space>
                    );
                  },
                },
                description: {
                  render: () => {
                    return 'Ant Design, a design language for background applications, is refined by Ant UED Team';
                  },
                },
                avatar: {},
                content: {
                  render: () => (
                    <div
                      style={{
                        minWidth: 200,
                        flex: 1,
                        display: 'flex',
                        justifyContent: 'flex-end',
                      }}
                    >
                      <div
                        style={{
                          width: '200px',
                        }}
                      >
                        <div>发布中</div>
                        <Progress percent={80} />
                      </div>
                    </div>
                  ),
                },
                actions: {
                  render: () => {
                    return <a key="invite">邀请</a>;
                  },
                },
              }}
            />
          </Row>
        </Content>

        <Footer style={{ textAlign: "center" }}>
          © {new Date().getFullYear()} Мареев Иван
        </Footer>
      </Layout>
    </Layout>
  );
}
