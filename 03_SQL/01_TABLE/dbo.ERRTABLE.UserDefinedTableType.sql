/****** Object:  UserDefinedTableType [dbo].[ERRTABLE]    Script Date: 2024/02/19 0:05:09 ******/
CREATE TYPE [dbo].[ERRTABLE] AS TABLE(
	[id] [int] IDENTITY(1,1) NOT NULL,
	[message_cd] [nvarchar](50) NULL,
	[item] [nvarchar](100) NULL,
	[order_by] [int] NULL,
	[error_typ] [int] NULL,
	[value1] [int] NULL,
	[value2] [nvarchar](255) NULL,
	[remark] [nvarchar](255) NULL
)
GO
