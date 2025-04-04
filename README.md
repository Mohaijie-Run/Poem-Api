<h1 align=center>Poem-Api</h1>
<p align=center><b>原创、免费 の《古诗文网》古诗内容查询API</b></p>
<p align=center>✨ 您的Star是我们的最大动力 ✨</p>

## 开发の原因？

> 本项目仅供学习和参考使用，若因此产生任何问题，我们不承担责任。

本项目源于对古诗文文化的深厚热爱与传承需求，旨在通过技术手段让更多人能够便捷地接触和学习中国传统文化。由于《古诗文网》拥有丰富的古诗文资源，但未公开提供API接口，我们通过爬虫技术获取其数据，开发一个高效、实用的查询工具，以满足学习者、开发者及文化爱好者在不同场景下的使用需求。

## 食用APIの方法？

### 古诗文搜索（search.php）
- 返回的格式：XML文档。
- 请求示例：GET <code>./search.php?type=唐多令</code>
- 功能：根据关键词搜索《古诗文网》中的诗篇，返回匹配的诗文标题和链接。

```xml
<response>
    <error>
        <message>请提供诗文标题</message>
    </error>
</response>
```

```xml
<response>
    <poem ofetch="https://www.gushiwen.cn/shiwenv_79730f08af17.aspx">唐多令·芦叶满汀洲 - 刘过</poem>
    <poem ofetch="https://www.gushiwen.cn/shiwenv_d06ebeb22bd3.aspx">唐多令·惜别 - 吴文英</poem>
    <poem ofetch="https://www.gushiwen.cn/shiwenv_0ada71494eb7.aspx">唐多令·柳絮 - 曹雪芹</poem>
</response>
```

> 在正式获取古诗文内容之前，请先通过古诗文链接查询接口进行检索。上述接口在请求后可能返回的结果已通过示例展示，包括成功与失败两种情况。

### 古诗文查询（askresult.php）
- 返回的格式：XML文档。
- 功能：根据关键词搜索《古诗文网》中的诗篇，返回匹配的诗文标题和链接。
- 请求示例：GET <code>./askresult.php?poem=https://www.gushiwen.cn/shiwenv_c35a60c1a8e2.aspx</code>

```xml
<response>
    <error>
        <message>该诗文链接无效</message>
    </error>
</response>
```

```xml
<response>
    <title>唐多令·芦叶满汀洲</title>
    <line>安远楼小集，侑觞歌板之姬黄其姓者，乞词于龙洲道人，为赋此《唐多令》。</line>
    <line>同柳阜之、刘去非、石民瞻、周嘉仲、陈孟参、孟容。</line>
    <line>时八月五日也。</line>
    <line>芦叶满汀洲，寒沙带浅流。</line>
    <line>二十年重过南楼。</line>
    <line>柳下系船犹未稳，能几日，又中秋。</line>
    <line>黄鹤断矶头，故人今在否？旧江山浑是新愁。</line>
    <line>欲买桂花同载酒，终不似，少年游。</line>
    <line>(在否 一作：在不；终不似 一作：终不是)。</line>
</response>
```

> 通过对诗文链接的检索，我们可以直接获取到古诗文的内容。上述接口在请求后可能返回的结果已通过示例展示，包括成功与失败两种情况。

## 该项目の许可证信息？

**Apache License 2.0**允许你自由使用、修改和分发代码，包括用于商业用途。唯一的要求是，你必须在所有代码副本中保留原始的版权声明和许可证声明，并在对代码进行修改时，明确标明所做的变更。此外，该许可证还提供了专利权的保护，确保用户不会因使用该代码而面临专利诉讼。总体来说，Apache 2.0提供了高度的自由度，同时确保了对原作者和修改者的合法权益的尊重。
