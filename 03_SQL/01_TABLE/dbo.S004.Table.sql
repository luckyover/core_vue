/****** Object:  Table [dbo].[S004]    Script Date: 2024/02/19 0:05:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[S004](
	[auth_role_div] [smallint] NOT NULL,
	[prg_cd] [nvarchar](30) NOT NULL,
	[fnc_cd] [nvarchar](50) NOT NULL,
	[fnc_use_div] [smallint] NOT NULL,
	[memo] [nvarchar](50) NULL,
	[cre_user_cd] [nvarchar](5) NULL,
	[cre_prg] [nvarchar](30) NULL,
	[cre_ip] [nvarchar](20) NULL,
	[cre_tm] [datetime2](7) NULL,
	[upd_user_cd] [nvarchar](5) NULL,
	[upd_prg] [nvarchar](30) NULL,
	[upd_ip] [nvarchar](20) NULL,
	[upd_tm] [datetime2](7) NULL,
	[del_user_cd] [nvarchar](5) NULL,
	[del_prg] [nvarchar](30) NULL,
	[del_ip] [nvarchar](20) NULL,
	[del_tm] [datetime2](7) NULL,
	[del_flg] [int] NULL,
 CONSTRAINT [PK_s_auth] PRIMARY KEY CLUSTERED 
(
	[auth_role_div] ASC,
	[prg_cd] ASC,
	[fnc_cd] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
